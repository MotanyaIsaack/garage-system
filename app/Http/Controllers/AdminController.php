<?php

namespace App\Http\Controllers;

use App\Service;
use App\Request;
use App\User;
use App\VehicleCategory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function guard(){
        return Auth::guard('admin');
    }

    /**
     * @return Renderable
     */
    public function index()
    {
        $vehicle_categories = VehicleCategory::all();
        $garage_services = Service::all();
        $user_count = User::all()->whereIn('role_id',[3])->count();
        $mechanic_count = User::all()->whereIn('role_id',[2])->count();
        $appointments = Request::all()->count();
        return view('admin.home',
            [
                'vehicle_categories'=>$vehicle_categories,'garage_services'=>$garage_services,
                'users'=>$user_count,'mechanics'=>$mechanic_count,'appointments'=>$appointments
            ]
        );
    }

}
