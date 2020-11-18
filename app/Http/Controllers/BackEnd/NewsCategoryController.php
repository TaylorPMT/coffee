<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
use App\Models\CategorysModel;
use App\Models\NewsCategory;
use App\Models\NewsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class NewsCategoryController extends Controller
{
    //
    public $_controllerName="Đây Là Trang Quản Lý Danh Mục Tin Tức";
    public $_controllersDes = "Quản Lý Quản Lý Danh Mục Tin Tức";
    protected $_model;
    protected $_root='BackEnd/pages/news/';
    public function __construct(NewsCategory $NewsCategory)
    {
        $this->_model=new RepositoryHome($NewsCategory);
        View::share('controllerName', $this->_controllerName);
        View::share('controllersDes',$this->_controllersDes);
    }
    public function message($message,$type)
    {
        return [
            "message"=>$message,
            "type"=>$type,
        ];
    }
    public function messageView($message,$type)
    {
        return [
            "msg"=>$message,
            "type"=>$type,
        ];
    }
    public function index()
    {
        return view($this->_root.'index');
    }
    public function getDataAjax(Request $request)
    {
     if($request->ajax())
     {
        $queryTable=$this->_model->getAllE();

        return DataTables::of($queryTable)
        ->addColumn('ten_dmtintuc',function($queryTable){
            $name=$queryTable->ten_dmtintuc;
            return $name;
        })->addColumn('status',function($queryTable){
            $status='<button class="btn btn-primary btn-fab btn-fab-mini btn-round"><span class="material-icons">';
                $status.=$queryTable->trangthai==0?"visibility_off":"visibility";
                $status.='<span></button>';
                return $status;
        })->addColumn('action',function ($queryTable){
            $action='<button class="btn btn-primary btn-round delete" value='.$queryTable->id.' >
            <i class="material-icons">';
            $action.="delete_forever";
            $action.='</button></i>';
            $action.="  ";
            $action.='<a href="' . url('quan-ly/news/update/' . $queryTable->id) . '" class="btn btn-primary btn-round">
                        <i class="material-icons">';
            $action.="update";
            $action.='</i></a>';
            $action.='<a href="' . url('quan-ly/news-detail/' . $queryTable->id) . '" class="btn btn-primary btn-round">
                        <i class="material-icons">';
            $action.="settings";
            $action.='</i></a>';
            $action.='<button class="btn btn-primary btn-round update_status" value='.$queryTable->id.'>
                        <i class="material-icons">';
            $action.="block";
            $action.='</button></i>';
            return $action;
        })
        ->rawColumns(['ten_dmtintuc','action','status'])->make('true');
     }
    }
    public function delete(Request $request , $id)
    {
        if($request->ajax())
        {
            $NewsCategory=NewsModel::where('id_dmtintuc',$id)->first();
            if($NewsCategory)
            {
                return response()->json($this->message('Không Thể Xóa Vì Có Tin Liên Quan',false));
            }
          $this->_model->deleteIdE($id);
           return response()->json($this->message('Xóa Thành Công',true));
        }
    }
    public function updateStatus(Request $request,$id)
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
    public function save(Request $request)
    {
        //kiểm tra xem đang dùng method nào
        if($request->isMethod('GET'))
        {
            return view($this->_root.'save');
        }else
        {
            $rules=[
                'ten_dmtintuc'=>'required|unique:news_category',
                'trangthai'=>'required|numeric',
            ];

            $validator=validator()->make($request->all(),$rules,[
                'ten_dmtintuc.required'=>'Không Được Bỏ Trống',
                'ten_dmtintuc.unique'=>'Trùng Tên Đã Có',
                'trangthai.required'=>'Không Được Bỏ Trống Trạng Thái',
                'trangthai.numeric'=>'Kiểu Dữ Liệu Không Đúng',
            ]);
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator);
            }
            $dataAdd=[
                'ten_dmtintuc'=>$request->ten_dmtintuc,
                'trangthai'=>$request->trangthai,
            ];
            $this->_model->createDataE($dataAdd);
            return redirect()->back()->with('message',$this->messageView('Thêm Thành Công','success'));
        }
    }
    public function update(Request $request,$id)
    {
        if($request->isMethod('GET'))
        {
            $news=$this->_model->findOrFailE($id);
            return view($this->_root.'update',compact('news'));
        }else
        {
            $rules =[
                'ten_dmtintuc'=>'required|unique:news_category,ten_dmtintuc,'.$id,
                'trangthai'=>'required|numeric',
            ];
            $validator=validator()->make($request->all(),$rules,[
                'ten_dmtintuc.required'=>'Tên Không Được Bỏ Trống',
                'ten_dmtintuc.news_category'=>'Không Được Trùng',
                'trangthai.required'=>'Trạng Thái Không Được Bỏ Trống',
                'trangthai.numeric'=>'Dạng Số',
            ]);
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator);
            }
            $dataAdd=[
                'ten_dmtintuc'=>$request->ten_dmtintuc,
                'trangthai'=>$request->trangthai,
            ];
            $this->_model->updateDataE($id,$dataAdd);
            return redirect()->back()->with('message',$this->messageView('Cập Nhật Thành Công','success'));

        }
    }
}
