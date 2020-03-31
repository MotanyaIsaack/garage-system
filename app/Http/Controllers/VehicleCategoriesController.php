<?php

namespace App\Http\Controllers;

use App\VehicleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VehicleCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function guard(){
        return Auth::guard('admin');
    }

    public function get_vehicle_categories_json(){
        $vehicle_categories = VehicleCategory::all();
        foreach ($vehicle_categories as $vehicle_category => $value) {
            $vehicle_categories[$vehicle_category]['actions'] =

                ($vehicle_categories[$vehicle_category]['suspended'] ?
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
        return response()->json($vehicle_categories);
    }
    public function add_vehicle_category(Request $request){
        $validator = Validator::make(
            ['name'=>$request->name],
            ['name' => 'required|unique:tbl_vehiclecategories']);
        if ($validator->fails()){
            $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
            return response()->json(['ok'=>false,'msg'=>$fieldsWithErrorMessagesArray]);
        }
        if ($request->action === 'insert'){
            $vehicle_category = VehicleCategory::create(['name'=>$request->name]);
            return $vehicle_category ? response()->json(['ok'=>true,'msg'=>$request->name.' inserted successfully']) :
                response()->json(['ok'=>false,'msg'=>$request->name.' not inserted']);
        }else{
            VehicleCategory::where('category_id',$request->category_id)
                ->update(['name'=>$request->name]);
            return response()->json(['ok'=>true,'msg'=>$request->name.' has been updated']);
        }
    }
    public function suspend_vehicle_category(Request $request){
        VehicleCategory::where('category_id',$request->category_id)
            ->update(['suspended'=>true]);
        return response()->json(['ok'=>true,'msg'=>'Vehicle Category suspended']);
    }
    public function restore_vehicle_category(Request $request){
        VehicleCategory::where('category_id',$request->category_id)
            ->update(['suspended'=>false]);
        return response()->json(['ok'=>true,'msg'=>'Vehicle Category unsuspended']);
    }

}
