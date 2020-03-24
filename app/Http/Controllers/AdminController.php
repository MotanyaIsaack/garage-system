<?php

namespace App\Http\Controllers;

use App\Spare;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
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
        return Auth::guard('admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('admin.home');
    }

    public function get_spares_json(){
        $spares = Spare::all()->toArray();

        foreach ($spares as $key => $value){
            $spares[$key]['actions'] =
                ($spares[$key]['suspended'] ?
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

        return response()->json($spares,200);
    }

    public function add_spares(Request $request){
        $data = ['name'=>$request->name,'stock'=>$request->stock];
        $validator = Validator::make(
            array(
                'name'=> $request->name,
                'stock'=>$request->stock
            ),
            array(
                'name' => 'required|unique:tbl_spares',
                'stock' => 'required'
            )
        );
        if ($validator->fails()) {
            $fieldsWithErrorMessagesArray = $validator->messages()->get('*');
            return response()->json(['ok'=>false,'msg'=>$fieldsWithErrorMessagesArray],200);
        }
        if ($request->action === 'insert'){
            $spare = Spare::create($data);
            return ($spare ? response()->json(['ok'=>true,'msg'=>'Stock Inserted Successfully'],200) : response()->json(['ok'=>false,'msg'=>'Stock Not Inserted'],200));
        }else{
            Spare::where('spare_id',$request->spare_id)
                ->update($data);
            return response()->json(['ok'=>true,'msg'=>'Stock Updated Successfully'],200);
        }
    }

    public function suspend_spares(Request $request){
        Spare::where('spare_id',$request->spare_id)
            ->update(['suspended'=>1]);
        return response()->json(['ok'=>true,'msg'=>'Stock Deleted Successfully'],200);
    }
    public function restore_spares(Request $request){
        Spare::where('spare_id',$request->spare_id)
            ->update(['suspended'=>0]);
        return response()->json(['ok'=>true,'msg'=>'Stock Restored Successfully'],200);
    }
}
