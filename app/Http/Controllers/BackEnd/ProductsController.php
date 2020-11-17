<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
use App\Models\CategorysModel;
use App\Models\MenuModel;
use App\Models\ProductModel;
use Illuminate\Support\Facades\View;
use App\Models\OrderDetailModel;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Http\Repository\UploadImage\RepositoryUploadImage;
use App\Library\Helper;

class ProductsController extends Controller
{
    public $_controllerName = "Quản Lý Sản Phẩm ";
    public $_controllersDes = "Quản Lý Sản Phẩm ";
    public $_root = 'BackEnd/pages/product/';
    protected $_model;
    public $upload;
    public function __construct(ProductModel $ProductModel, RepositoryUploadImage $upload)
    {
        $this->_model = new RepositoryHome($ProductModel);
        View::share('controllerName', $this->_controllerName);
        View::share('controllersDes', $this->_controllersDes);
        $this->upload = $upload;
    }
    public function message($message, $type)
    {
        return [
            "message" => $message,
            "type" => $type,
        ];
    }
    public function index()
    {

        return view($this->_root . 'index');
    }
    public function getDataAjax(Request $request)
    {
        if ($request->ajax()) {
            $queryTable = $this->_model->getAllE();
            return DataTables::of($queryTable)
                ->addColumn('name', function ($queryTable) {
                    $name = $queryTable->name;
                    return $name;
                })->addColumn('mota', function ($queryTable) {
                    $mota = $queryTable->mota;
                    return $mota;
                })->addColumn('hinhanh', function ($queryTable) {
                    $hinhanh = "<img src='$queryTable->hinhanh' class='' style='width:150px;height:150px' />";
                    return $hinhanh;
                })->addColumn('gia', function ($queryTable) {
                    $gia = number_format($queryTable->gia,0,',','.').' VNĐ';
                    return $gia;
                })->addColumn('gia_km', function ($queryTable) {
                    $gia_km = number_format($queryTable->gia_km,0,',','.').' VNĐ';
                    return $gia_km;
                })->addColumn('id_madm', function ($queryTable) {
                    $id_madm = $queryTable->getNameCategory->name;
                    return $id_madm;
                })->addColumn('trangthai', function ($queryTable) {
                    $trangthai='<button class="btn btn-primary btn-fab btn-fab-mini btn-round"><span class="material-icons">';
                    $trangthai.=$queryTable->trangthai==0?"visibility_off":"visibility";
                    $trangthai.='<span></button>';
                    return $trangthai;
                })->addColumn('action', function ($queryTable) {
                    $action = '<button class="btn btn-primary btn-round delete" value=' . $queryTable->id . ' >
                     <i class="material-icons">';
                    $action .= "delete_forever";
                    $action .= '</button></i>';
                    $action .= "  ";
                    $action .= '<a href="' . url('quan-ly/product/update/' . $queryTable->id) . '" class="btn btn-primary btn-round">
                     <i class="material-icons">';
                    $action .= "update";
                    $action .= '</i></a>';
                    $action.='<button class="btn btn-primary btn-round update_status" value='.$queryTable->id.'>
                    <i class="material-icons">';
                    $action.="block";
                    $action.='</button></i>';
                    return $action;
                })
                ->rawColumns(['name', 'mota', 'hinhanh', 'gia', 'gia_km', 'id_madm', 'trangthai', 'action'])->make('true');
        }
    }
    public function addProduct(Request $request)
    {
        if ($request->isMethod('GET')) {
            $category = CategorysModel::all();
            return view($this->_root . 'save', compact('category'));
        } else {

            $rules = [
                'name' => 'required',
                'hinhanh' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
                'gia' => 'required|numeric|min:0',
                'gia_km' => 'required|numeric|min:0',
                'mota' =>'required',
            ];
            $validator = validator()->make($request->all(), $rules, [
                'name.required' => 'Tên sản phẩm không được để trống',
                'hinhanh.mimes' => 'Sai định dạng hình ảnh ',
                'hinhanh.required' => 'Không được bỏ trống hình',
                'gia.required' => 'Giá tiền không được bỏ trống',
                'gia.numeric' => 'Sai định dạng giá tiền',
                'gia.min' => 'Giá tiền phải từ 0 trở lên',
                'gia_km.required' => 'Giá khuyến mãi nếu không có vui lòng nhập 0',
                'gia_km.numeric' => 'Sai định dạng giá tiền khuyến mãi',
                'gia_km.min' => 'Giá tiền khuyến mãi phải từ 0 trở lên',
                'mota.required' => 'Mô tả không được bỏ trống',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $hinhanh = $request->file('hinhanh');
            $this->upload->setUrl('/sanpham/');
            $dataAdd = [
                'name' => $request->name,
                'mota' => $request->mota,
                'hinhanh'=>$this->upload->compresImage($hinhanh),
                'gia' => $request->gia,
                'gia_km' => $request->gia_km,
                'trangthai' => $request->trangthai,
                'id_madm' => $request->id_madm,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            ];
            $create = ProductModel::create($dataAdd);
            return redirect()->route('admin.productIndex')->with("message", $this->message("Thêm Thành Công", "success"));
        }
    }
    public function updateProduct(Request $request,$id)
    {
        if ($request->isMethod('GET')) {
            $category = CategorysModel::all();
            $product = $this->_model->findOrFailE($id);
            return view($this->_root . 'update', compact('category','product'));
        } else {

            $rules = [
                'name' => 'required',
                'hinhanh' => 'mimes:jpeg,jpg,png,gif|max:10000',
                'gia' => 'required|numeric|min:0',
                'gia_km' => 'required|numeric|min:0',
                'mota' =>'required',
            ];
            $validator = validator()->make($request->all(), $rules, [
                'name.required' => 'Tên sản phẩm không được để trống',
                'hinhanh.mimes' => 'Sai định dạng hình ảnh ',
                'gia.required' => 'Giá tiền không được bỏ trống',
                'gia.numeric' => 'Sai định dạng giá tiền',
                'gia.min' => 'Giá tiền phải từ 0 trở lên',
                'gia_km.required' => 'Giá khuyến mãi nếu không có vui lòng nhập 0',
                'gia_km.numeric' => 'Sai định dạng giá tiền khuyến mãi',
                'gia_km.min' => 'Giá tiền khuyến mãi phải từ 0 trở lên',
                'mota.required' => 'Mô tả không được bỏ trống',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $hinhanh = $request->file('hinhanh');
            $this->upload->setUrl('/sanpham/');
            $updateProduct = $this->_model->findOrFailE($id);
            $dataAdd = [
                'name' => $request->name,
                'mota' => $request->mota,
                'hinhanh'=>$hinhanh!=NULL?$this->upload->compresImage($hinhanh):$updateProduct->hinhanh,
                'gia' => $request->gia,
                'gia_km' => $request->gia_km,
                'trangthai' => $request->trangthai,
                'id_madm' => $request->id_madm,
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            ];
            $updateProduct->update($dataAdd);
            return redirect()->route('admin.productIndex')->with("message", $this->message("Sửa Thành Công", "success"));
        }
    }
    public function updateStatusProduct(Request  $request,$id)
    {
        try {
          if($request->ajax())
          {
              $query = $this->_model->findOrFailE($id);
              $query->trangthai=$query->trangthai==0?1:0;
              $query->save();
              return response()->json(['message'=>'Cập Nhật Trạng Thái Thành Công','status'=>200]);
          }else
          {
              return redirect()->back();
          }
        }catch (\Exception $e)
        {
            return redirect()->back();
        }
    }
    public function deleteProduct(Request $request , $id)
    {
        if($request->ajax())
        {
            $product=OrderDetailModel::where('id_sanpham',$id)->first();

            if($product)
            {
                return response()->json($this->message('Không Thể Xóa Vì Có Đơn Hàng Liên Quan',false));
            }
          $this->_model->deleteIdE($id);
           return response()->json($this->message('Xóa Thành Công',true));
        }
    }


}
