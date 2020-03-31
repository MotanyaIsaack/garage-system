<?php

namespace App\Http\Controllers;

use App\Request as Appointments;
use App\Service;
use App\User;
use App\Pricing;
use App\VehicleCategory;
use App\VehicleTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function guard(){
        return Auth::guard('user');
    }

    public function get_categories_json(Request $request){
        $type_id = $request->type_id;
        $category_id = VehicleTypes::where(['type_id'=>$type_id])->first()->category_id;
        $categories = VehicleCategory::where(['category_id'=>$category_id])->first();

        return response()->json($categories);
    }

    public function get_services_json(Request $request){
        $category_id = $request->category_id;
        $services = Service::with(['pricing'=>function($query) use ($category_id){
            $query->where('category_id',$category_id);
        }])->get();

        return response()->json($services);
    }

    public function fill_amount(Request $request){
        $service_ids = $request->service_id;
        $amount = 0;
        foreach ($service_ids as $service_id => $value){
            $amount += Pricing::where('service_id',$service_ids[$service_id])->first()->amount;
        }
        return response()->json($amount);
    }

    public function get_requests_json(){
        $requests = Appointments::all();
        foreach ($requests as $request => $value){
            $requests[$request]['mechanic'] =
                !isset($requests[$request]['mechanic_id']) ? 'NOT ASSIGNED' :
                    User::find($requests[$request]['mechanic_id'])->name;
            $requests[$request]['completed'] =
                $requests[$request]['completed'] ? 'JOB COMPLETED' : 'JOB IN PROGRESS';
            $requests[$request]['paid'] =
                $requests[$request]['paid'] ? 'PAID' : 'NOT PAID';
            $requests[$request]['actions'] =
                $requests[$request]['completed'] == true && $requests[$request]['paid'] == false ?
                    '
                        <a class="btn btn-primary btn-sm active pay-button" aria-pressed="true">Pay</a>
                    '
                    : 'No Actions'
            ;
            $requests[$request]['category_name'] =
                VehicleCategory::where('category_id',$requests[$request]['category_id'])->first()->name;

        }
        return response()->json($requests);
    }

    public function add_request(Request $request){
        $insert_data =[
                'user_id'=>Auth::user()->user_id,'category_id'=>$request->category_id,'services'=>$request->services,
                'amount'=>$request->amount
        ];

        $is_inserted = Appointments::create($insert_data);
        return $is_inserted ? response()->json(['ok'=>true,'msg'=>'Appointment created successfully']) :
            response()->json(['ok'=>false,'msg'=>'Appointment failed to be created']);
    }
}
