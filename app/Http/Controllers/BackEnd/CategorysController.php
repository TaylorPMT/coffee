<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
use App\Models\CategorysModel;
use App\Models\MenuModel;
use App\Models\ProductModel;
use Illuminate\Support\Facades\View;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class CategorysController extends Controller
{
    //
    public $_controllerName="Trang Quản Lý Loại ";
    public $_controllersDes = "Quản Lý Loại Sản Phẩm";
    public $_root='BackEnd/pages/category/';
    protected $_model;
    public function __construct(CategorysModel $CategorysModel)
    {
        $this->_model=new RepositoryHome($CategorysModel);
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
        ->addColumn('name',function($queryTable){
            $name=$queryTable->name;
            return $name;
        })->addColumn('action',function ($queryTable){
            $action='<button class="btn btn-primary btn-round delete" value='.$queryTable->id.' >
                     <i class="material-icons">';
            $action.="delete_forever";
            $action.='</button></i>';
            $action.="  ";
     $action.='<a href="' . url('quan-ly/category/update/' . $queryTable->id) . '" class="btn btn-primary btn-round">
                     <i class="material-icons">';
            $action.="update";
            $action.='</i></a>';

            return $action;
        })
        ->rawColumns(['name','action'])->make('true');
     }
    }
    public function deleteCategory(Request $request , $id)
    {
        if($request->ajax())
        {
            $product=ProductModel::where('id_madm',$id)->first();
            if($product)
            {
                return response()->json($this->message('Không Thể Xóa Vì Có Sản Phẩm Liên Quan',false));
            }
            $this->_model->deleteIdE($id);
           return response()->json($this->message('Xóa Thành Công',true));
        }
    }
    public function addCategory(Request $request)
    {
        if($request->isMethod('GET'))
        {
            return view($this->_root.'save');
        }else
        { $rules=[
            'name'=>'required',
        ];
        $validator=validator()->make($request->all(),$rules,[
            'name.required' => 'Tên thể loại không được để trống',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
            $dataAdd = [
                'name' => $request->name,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            ];
            $create = CategorysModel::create($dataAdd);
            return redirect()->route('admin.categoryIndex')->with("message",$this->message("Thêm Thành Công","success"));

        }
    }
    public function updateCategory(Request $request, $id)
    {
        if($request->isMethod('GET'))
        {
            $category = $this->_model->findOrFailE($id);
            return view($this->_root.'update',compact('category'));
        }else
        { $rules=[
            'name'=>'required',
        ];
        $validator=validator()->make($request->all(),$rules,[
            'name.required' => 'Tên thể loại không được để trống',
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $category = $this->_model->findOrFailE($id);
            $dataAdd = [
                'name' => $request->name,
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            ];
            $category->update($dataAdd);
            return redirect()->route('admin.categoryIndex')->with("message",$this->message("Sửa Thành Công","success"));

        }
    }
}
