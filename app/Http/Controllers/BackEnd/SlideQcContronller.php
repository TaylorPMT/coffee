<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
use App\Http\Repository\UploadImage\RepositoryUploadImage;
use App\Models\SlideModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class SlideQcContronller extends Controller
{
    //
    public $_controllerName = "Quản Lý Banner Quảng Cáo ";
    public $_controllersDes = "Quản Lý Quảng Cáo ";
    public $_root = 'BackEnd/pages/banner/';
    protected $_model;
    public $upload;
    public function __construct(SlideModel $SlideModel, RepositoryUploadImage $upload)
    {
        $this->_model = new RepositoryHome($SlideModel);
        View::share('controllerName', $this->_controllerName);
        View::share('controllersDes', $this->_controllersDes);
        $this->upload = $upload;
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
    public function getData(Request $request)
    {
        if($request->ajax())
     {
        $queryTable=$this->_model->getAllE();

        return DataTables::of($queryTable)
        ->addColumn('image',function($queryTable){
            $name='<img src="'.$queryTable->image.'" style="width:200px;height:200px;" />';
            return $name;
        })->addColumn('action',function ($queryTable){
            $action='<button class="btn btn-primary btn-round delete" value='.$queryTable->id.' >
                     <i class="material-icons">';
            $action.="delete_forever";
            $action.='</button></i>';
            $action.="  ";
     $action.='<a href="' . url('quan-ly/banner/update/' . $queryTable->id) . '" class="btn btn-primary btn-round">
                     <i class="material-icons">';
            $action.="update";
            $action.='</i></a>';

            return $action;
        })
        ->rawColumns(['image','action'])->make('true');
     }
    }
    public function save(Request $request)
    {
        if($request->isMethod('GET'))
        {
            return view($this->_root.'save');
        }else
        {
           $rules=[
               'href'=>'required',
               'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
           ];
           $validator=validator()->make($request->all(),$rules,[
                'href.required'=>'Bắt Buộc Có link',
                'image.required'=>'Chọn Hình',
                'image.mimes'=>'Chọn Đúng File Hình',
           ]);
           if($validator->fails())
           {
               return redirect()->back()->withErrors($validator);
           }
           $hinhanh = $request->file('image');
           $this->upload->setUrl('/banner/');
           $dataAdd=[
               'link'=>$request->href,
               'image'=>$this->upload->compresImage($hinhanh),
               'id_admin'=>Auth::guard('admin')->user()->id,
           ];
           $this->_model->createDataE($dataAdd);
           return redirect()->back()->with("message", $this->messageView("Thêm Thành Công", "success"));
        }
    }
    public function delete(Request $request,$id)
    {
        if($request->ajax())
        {
            $this->_model->deleteIdE($id);
            return response()->json($this->message('Xóa Thành Công',true));
        }
    }
    public function update(Request $request,$id)
    {
        if($request->isMethod('GET'))
        {
            $queryBanner =$this->_model->findOrFailE($id);
            return view($this->_root.'update',compact('queryBanner'));
        }else
        {
            $rules=[
                'href'=>'required',
                'image' => 'mimes:jpeg,jpg,png,gif|max:10000',
            ];
            $validator=validator()->make($request->all(),$rules,[
                 'href.required'=>'Bắt Buộc Có link',
                 'image.required'=>'Chọn Hình',
                 'image.mimes'=>'Chọn Đúng File Hình',
            ]);
            if($validator->fails())
            {
                return redirect()->back()->withErrors($validator);
            }
            $queryBanner=$this->_model->findOrFailE($id);
            $hinhanh = $request->file('image');
            $this->upload->setUrl('/banner/');
            $dataAdd=[
                'link'=>$request->href,
                'image'=>$hinhanh!=NULL?$this->upload->compresImage($hinhanh):$queryBanner->image,
                'id_admin'=>Auth::guard('admin')->user()->id,
            ];
            $this->_model->updateDataE($id,$dataAdd);
            return redirect()->back()->with("message", $this->messageView("Cập Nhật Thành Công", "success"));

        }
    }
}
