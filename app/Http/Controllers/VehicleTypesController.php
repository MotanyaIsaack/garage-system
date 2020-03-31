<?php

namespace App\Http\Controllers;

use App\VehicleCategory;
use App\VehicleTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VehicleTypesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function guard(){
        return Auth::guard('admin');
    }

    public function get_vehicle_types_json(){
        $vehicle_types = VehicleTypes::all();
        foreach ($vehicle_types as $vehicle_type => $value) {
            $vehicle_types[$vehicle_type]['actions'] =
                ($vehicle_types[$vehicle_type]['suspended'] ?
                    '
                        <a class="btn btn-primary btn-sm active edit-button" aria-pressed="true">Edit</a>
                        <a class="btn btn-secondary btn-sm active restore-button" aria-pressed="true">Restore</a>
                    ':
                    '
                        <a class="btn btn-primary btn-sm active edit-button" aria-pressed="true">Edit</a>
                        <a class="btn btn-danger btn-sm active delete-button" aria-pressed="true">Delete</a>
                    '
                );
            $vehicle_types[$vehicle_type]['category_name'] =
                VehicleCategory::where(['category_id'=>$vehicle_types[$vehicle_type]['category_id']])->first()->name;
        }
        return response()->json($vehicle_types);
    }

    public function add_vehicle_type(Request $request){
        try {
            $where_clause = ['type_id'=>$request->type_id,'make'=>$request->make,'model'=>$request->model];
            if ($request->action === 'insert'){
                $validator = Validator::make(
                    [
                        'make'=>$request->make,
                        'model'=>$request->model,
                        'category_id'=>$request->category_id
                    ],
                    [
                        'make'=>'required',
                        'model'=>'required|unique:tbl_vehicletypes',
                        'category_id'=>'required'
                    ]
                );
                if ($validator->fails()){
                    $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
                    return response()->json(['ok'=>false,'msg'=>$fieldsWithErrorMessagesArray]);
                }
                $vehicle_type = VehicleTypes::create(['category_id'=>$request->category_id,'make'=>$request->make,'model'=>$request->model]);
                return $vehicle_type ? response()->json(['ok'=>true,'msg'=>$request->make.' '.$request->model.' inserted successfully']) :
                    response()->json(['ok'=>false,'msg'=>$request->name.' not inserted']);
            }else{
                $vehicle_type_exists = VehicleTypes::where($where_clause)->exists();
                if ($vehicle_type_exists) throw new \Exception('Vehicle Type Already Exists');
                VehicleTypes::where(['type_id'=>$request->type_id])
                    ->update(['category_id'=>$request->category_id,'make'=>$request->make,'model'=>$request->model]);
                return response()->json(['ok'=>true,'msg'=>'Vehicle Type has been updated']);
            }
        }catch (\Throwable $th){
            return response()->json(['ok'=>false,'msg'=>$th->getMessage()]);
        }

    }

    public function suspend_vehicle_type(Request $request){
        $is_suspended = VehicleTypes::where(['type_id'=>$request->type_id])->update(['suspended'=>true]);
        return $is_suspended ? response()->json(['ok'=>true,'msg'=>'Vehicle type suspended']) : response()->json(['ok'=>false,'msg'=>'Vehicle type could not be suspended']);
    }
    public function restore_vehicle_type(Request $request){
        $is_restored = VehicleTypes::where(['type_id'=>$request->type_id])->update(['suspended'=>false]);
        return $is_restored ? response()->json(['ok'=>true,'msg'=>'Vehicle type restored']) : response()->json(['ok'=>false,'msg'=>'Vehicle type could not be restored']);
    }
}
