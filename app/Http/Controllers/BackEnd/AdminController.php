<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    //
    public $controllers=" Quản Lý Tài Khoản";
    public $controllersDes="Quản Lý Tài Khoản Thông Tin ";
    protected $_model;
    public function __construct(Admin $Admin)
    {   $this->_model=new RepositoryHome($Admin);
        View::share('controllersDes',$this->controllersDes);
        View::share('controllerName',$this->controllers);
    }
    public function index()
    {
        return view('BackEnd.pages.admin.index');
    }
    public function message($message, $type)
    {
        return [
            "message" => $message,
            "type" => $type,
        ];
    }
    public function messageView($message,$type)
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
            $update->name=$request->full_name;
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
    public function tableadmin(Request $request)
    {
        return view('BackEnd.pages.admin.indexTable');
    }
    public function getData(Request $request)
    {
            if($request->ajax())
        {
            $queryTable=$this->_model->getAllE();

            return DataTables::of($queryTable)
            ->addColumn('name',function($queryTable){
                $name=$queryTable->name;
                return $name;
            })->addColumn('status',function($queryTable){
                $status='<button class="btn btn-primary btn-fab btn-fab-mini btn-round"><span class="material-icons">';
                    $status.=$queryTable->trangthai==0?"visibility_off":"visibility";
                    $status.='<span></button>';
                    return $status;
            })->addColumn('role',function($queryTable){
                return $queryTable->role ==1 ? 'Full Quyền':'Không Có Quyền';
            })->addColumn('sdt',function($queryTable){
                return $queryTable->sdt;
            })
            ->addColumn('action',function ($queryTable){


                $action='<a href="' . url('quan-ly/quan-ly-thong-tin/update/' . $queryTable->id) . '" class="btn btn-primary btn-round">
                            <i class="material-icons">';
                $action.="settings";
                $action.='</i></a>';
                $action.='<button class="btn btn-primary btn-round update_status" value='.$queryTable->id.'>
                            <i class="material-icons">';
                $action.="block";
                $action.='</button></i>';
                return $action;
            })
            ->rawColumns(['name','action','status','role','sdt'])->make('true');
        }
    }
    public function updateStatus(Request $request ,$id)

    {
        if($request->ajax())
        {
            $NewsCategory=$this->_model->findOrFailE($id);
            if(!$NewsCategory)
            {
                return response()->json($this->message('Không Tìm Thấy Kết Quả',false));
            }

            $NewsCategory->update(['trangthai'=>$NewsCategory->trangthai == 1 ? 0:1]);
            return response()->json($this->message('Cập Nhật Trạng Thái Thành Công',true));

        }
    }
    public function update_profile(Request $request,$id)
    {
       if($request->isMethod('GET'))
       {
        $dataAdmin=$this->_model->findOrFailE($id);
        return view('BackEnd.pages.admin.update',compact('dataAdmin'));
       }else
       {
          $this->_model->updateDataE($id,$request->all());
          return redirect()->back()->with("message", $this->messageView("Cập Nhật Thành Công", "success"));

       }
    }
    public function save(Request $request )
    {
        if($request->isMethod('GET'))
        {
            return view('BackEnd.pages.admin.save');
        }else
        {
            $rules=[
                'email'=>'required|unique:admin',
            ];
            $validator=validator()->make($request->all(),$rules,[
                'email.unique'=>'Trùng Email',
            ]);
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator);
            }
            $dataAdmin=[
                'name'=>$request->name,
                'email'=>$request->email,
                'sdt'=>$request->sdt,
                'role'=>$request->role,
                'trangthai'=>$request->trangthai,
                'diachi'=>$request->diachi,
                'password'=>bcrypt($request->password),
            ];
            $this->_model->createDataE($dataAdmin);
            return redirect()->back()->with("message", $this->messageView("Thêm thành Công", "success"));

        }

    }
}
