<?php

namespace App\Http\Controllers;

use App\Service;
use App\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GarageServicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function guard(){
        return Auth::guard('admin');
    }

    public function get_garage_services_json(){
        $garage_services = Service::all();
        foreach ($garage_services as $service => $value) {
            $garage_services[$service]['actions'] =

                ($garage_services[$service]['suspended'] ?
                    '
                        <a class="btn btn-primary btn-sm active edit-button" aria-pressed="true">Edit</a>
                        <a class="btn btn-secondary btn-sm active restore-button" aria-pressed="true">Restore</a>
                    ':
                    '
                        <a class="btn btn-primary btn-sm active edit-button" aria-pressed="true">Edit</a>
                        <a class="btn btn-danger btn-sm active delete-button" aria-pressed="true">Delete</a>
                    '
                );
        }
        return response()->json($garage_services);
    }
    public function add_garage_service(Request $request){
        $validator = Validator::make(
            ['name'=>$request->service_name],
            ['name' => 'required|unique:tbl_services']);
        if ($validator->fails()){
            $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
            return response()->json(['ok'=>false,'msg'=>$fieldsWithErrorMessagesArray]);
        }
        if ($request->action === 'insert'){
            $garage_service = Service::create(['name'=>$request->service_name]);
            return $garage_service ? response()->json(['ok'=>true,'msg'=>$request->service_name.' inserted successfully']) :
                response()->json(['ok'=>false,'msg'=>$request->service_name.' not inserted']);
        }else{
            Service::where('service_id',$request->service_id)
                ->update(['name'=>$request->service_name]);
            return response()->json(['ok'=>true,'msg'=>$request->service_name.' has been updated']);
        }
    }
    public function suspend_garage_service(Request $request){
        $is_suspended = Service::where('service_id',$request->service_id)
            ->update(['suspended'=>true]);
        return $is_suspended ? response()->json(['ok'=>true,'msg'=>'Vehicle Category suspended']) : response()->json(['ok'=>false,'msg'=>'Could not process your request at this time']);
    }
    public function restore_garage_service(Request $request){
        $is_restored = Service::where('service_id',$request->service_id)
            ->update(['suspended'=>false]);
        return $is_restored ? response()->json(['ok'=>true,'msg'=>'Vehicle Category unsuspended']) : response()->json(['ok'=>false,'msg'=>'Could not process your request at this time']);
    }

}
