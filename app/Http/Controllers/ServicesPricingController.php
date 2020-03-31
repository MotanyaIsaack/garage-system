<?php

namespace App\Http\Controllers;

use App\Pricing;
use App\Service;
use App\VehicleCategory;
use App\VehicleTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ServicesPricingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function guard(){
        return Auth::guard('admin');
    }

    public function get_services_pricing_json(){
        $services_pricing = Pricing::all();
        foreach ($services_pricing as $pricing => $value) {
            $services_pricing[$pricing]['actions'] =
                ($services_pricing[$pricing]['suspended'] ?
                    '
                    <a class="btn btn-primary btn-sm active edit-button" aria-pressed="true">Edit</a>
                    <a class="btn btn-secondary btn-sm active restore-button" aria-pressed="true">Restore</a>
                ':
                    '
                    <a class="btn btn-primary btn-sm active edit-button" aria-pressed="true">Edit</a>
                    <a class="btn btn-danger btn-sm active delete-button" aria-pressed="true">Delete</a>
                '
                );
            $services_pricing[$pricing]['category_name'] =
                VehicleCategory::where(['category_id'=>$services_pricing[$pricing]['category_id']])->first()->name;
            $services_pricing[$pricing]['service_name'] =
                Service::where(['service_id'=>$services_pricing[$pricing]['service_id']])->first()->name;
        }
        return response()->json($services_pricing);
    }

    public function add_service_pricing(Request $request){
        try {
            $where_clause = [
                'price_id'=>$request->price_id,'category_id'=>$request->category_id,
                'service_id'=>$request->service_id,'amount'=>$request->amount
            ];
            if ($request->action === 'insert'){
                $validator = Validator::make(
                    [
                        'category_id'=>$request->category_id,
                        'service_id'=>$request->service_id,
                        'amount'=>$request->amount
                    ],
                    [
                        'category_id'=>'required',
                        'service_id'=>'required',
                        'amount'=>'required'
                    ]
                );
                if ($validator->fails()){
                    $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
                    return response()->json(['ok'=>false,'msg'=>$fieldsWithErrorMessagesArray]);
                }
                $service_pricing = Pricing::create([
                    'category_id'=>$request->category_id,
                    'service_id'=>$request->service_id,'amount'=>$request->amount
                ]);
                return $service_pricing ? response()->json(['ok'=>true,'msg'=>'Pricing mapping saved successfully']) :
                    response()->json(['ok'=>false,'msg'=>'Pricing mapping could not be saved']);
            }else{
                $pricing_exists = Pricing::where($where_clause)->exists();
                if ($pricing_exists) throw new \Exception('Service Pricing mapping exists');
                $is_updated = Pricing::where(['price_id'=>$request->price_id])
                    ->update([
                        'category_id'=>$request->category_id,
                        'service_id'=>$request->service_id,'amount'=>$request->amount
                    ]);
                return $is_updated ? response()->json(['ok'=>true,'msg'=>'Pricing mapping has been updated'])
                    : response()->json(['ok'=>false,'msg'=>'Pricing mapping could not be updated']);
            }
        }catch (\Throwable $th){
            return response()->json(['ok'=>false,'msg'=>$th->getMessage()]);
        }

    }

    public function suspend_service_pricing(Request $request){
        $is_suspended = Pricing::where(['price_id'=>$request->price_id])->update(['suspended'=>true]);
        return $is_suspended ? response()->json(['ok'=>true,'msg'=>'Pricing mapping suspended']) : response()->json(['ok'=>false,'msg'=>'Could not process your request at this time']);
    }
    public function restore_service_pricing(Request $request){
        $is_restored = Pricing::where(['price_id'=>$request->price_id])->update(['suspended'=>false]);
        return $is_restored ? response()->json(['ok'=>true,'msg'=>'Pricing mapping restored']) : response()->json(['ok'=>false,'msg'=>'Could not process your request at this time']);
    }
}
