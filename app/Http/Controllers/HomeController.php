<?php

namespace App\Http\Controllers;

use App\VehicleTypes;
use Illuminate\Contracts\Support\Renderable;
use \App\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function guard(){
        return Auth::guard('user');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $appointments = Request::all()->count();
        $pending_appointments = Request::all()->where('completed',0)->count();
        $completed_appointments = Request::all()->where('completed',1)->count();
        $vehicle_types = VehicleTypes::all();

        return view('user.home',
            [
                'appointments'=>$appointments,'pending_appointments'=>$pending_appointments,
                'completed_appointments'=>$completed_appointments,'types'=>$vehicle_types
            ]
        );
    }
}
