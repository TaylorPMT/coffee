<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    //
    public $controllers=" Quản Lý Tài Khoản";
    public $controllersDes="Quản Lý Tài Khoản Thông Tin ";
    public function __construct()
    {
        View::share('controllersDes',$this->controllersDes);
        View::share('controllerName',$this->controllers);
    }
    public function index()
    {
        return view('BackEnd.pages.admin.index');
    }
    public function message($message,$type)
    {
        return [
            "msg"=>$message,
            "type"=>$type,
        ];
    }
    public function update(Request $request)
    {

        $update=Admin::find(Auth::guard('admin')->user()->id);
        if($request->has('full_name'))
        {
            $update->full_name=$request->full_name;
        }
        if($request->has('email'))
        {
            $update->email=$request->email;
        }
        if($request->has('password'))
        {
            $update->password=bcrypt($request->password);
        }
        $update->save();

        return redirect()->back()->with("message",$this->message("Cập Nhật Thành Công","success"));
    }
}
