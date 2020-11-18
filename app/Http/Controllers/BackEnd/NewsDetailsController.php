<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
use App\Http\Repository\UploadImage\RepositoryUploadImage;
use App\Models\NewsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;

class NewsDetailsController extends Controller
{
    //
    public $_controllerName="Đây Là Trang Quản Lý  Tin Tức Theo Danh Mục";
    public $_controllersDes = "Quản Lý Quản Lý  Tin Tức Theo Danh Mục";
    protected $_model;
    protected $_root='BackEnd/pages/news_details/';
    public $upload;
    public function __construct(NewsModel $NewsModel,RepositoryUploadImage $upload)
    {
        $this->_model=new RepositoryHome($NewsModel);
        View::share('controllerName', $this->_controllerName);
        View::share('controllersDes',$this->_controllersDes);
        $this->upload=$upload;

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

    public function index($id_tin)
    {
        return view($this->_root.'index',compact('id_tin'));
    }
    public function getDataAjax($id_tin,Request $request)
    {

           $queryTable=$this->_model->whereE([['id_dmtintuc','=',$id_tin]]);

           return DataTables::of($queryTable)
           ->addColumn('tieude',function($queryTable){
               $name=$queryTable->ten_dmtintuc;
               return $name;
           })->addColumn('tacgia',function($queryTable){
                $name=$queryTable->tacgia;
                return $name;
           })->addColumn('image',function($queryTable){
                $image='<img src="'.$queryTable->image.'"  style="width:200px;height:200px;"/>';
                return $image;
           })
           ->addColumn('action',function ($queryTable){
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
           ->rawColumns(['ten_dmtintuc','tacgia','action','image'])->make('true');

    }
    public function save(Request $request,$id_tin)
    {
        if($request->isMethod('GET'))
        {
            return view($this->_root.'save',compact('id_tin'));
        }else

        {
            $rules = [
                'tieude' => 'required|unique:news',
                'image' => 'mimes:jpeg,jpg,png,gif|max:10000',
                'tacgia'=>'required',
                'noidung' =>'required',
            ];
            $validator = validator()->make($request->all(), $rules, [
                'tieude.required' => 'Tên sản phẩm không được để trống',
                'image.mimes' => 'Sai định dạng hình ảnh ',
                'tieude.unique'=>'Đã Tồn Tại Tiêu Đề Này'

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $hinhanh = $request->file('image');
            $this->upload->setUrl('/tintuc/');

            $dataAdd = [
                'tieude' => $request->tieude,
                'noidung' => $request->noidung,
                'image'=>$this->upload->compresImage($hinhanh),
                'tacgia' => $request->tacgia,
                'id_dmtintuc' => $id_tin,
                'id_admin' => Auth::guard('admin')->user()->id,
            ];

        $this->_model->createDataE($dataAdd);
        return redirect()->back()->with('message',$this->messageView('Thêm Thành Công','success'));

        }
    }
    public function delete(Request $request,$id_tin)
    {
        if($request->ajax())
        {
            if($request->ajax())
            {
              $this->_model->deleteIdE($id_tin);
               return response()->json($this->message('Xóa Thành Công',true));
            }
        }
    }
}
