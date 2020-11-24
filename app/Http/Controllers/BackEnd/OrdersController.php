<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
use App\Models\CategorysModel;
use App\Models\MenuModel;
use App\Models\ProductModel;
use Illuminate\Support\Facades\View;
use App\Models\OrderDetailModel;
use App\Models\OrderModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Library\Helper;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public $_controllerName = "Quản Lý Đơn Hàng ";
    public $_controllersDes = "Quản Lý Đơn Hàng Gồm Đơn Hàng Và Chi Tiết Đơn Hàng ";
    public $_root = 'BackEnd/pages/orders/';
    protected $_model;
    public function __construct(OrderModel $OrderModel)
    {
        $this->_model = new RepositoryHome($OrderModel);
        View::share('controllerName', $this->_controllerName);
        View::share('controllersDes', $this->_controllersDes);
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
                ->addColumn('id', function ($queryTable) {
                    $id = $queryTable->id;
                    return $id;
                })->addColumn('id_khachhang', function ($queryTable) {
                    $id_khachhang = $queryTable->getNameCustomer->ten;
                    return $id_khachhang;
                })->addColumn('dongia', function ($queryTable) {
                    $dongia = number_format($queryTable->dongia,0,',','.').' VNĐ';
                    return $dongia;
                })->addColumn('payment', function ($queryTable) {
                    $payment = $queryTable->payment;
                    return $payment;
                })->addColumn('id_admin',function($queryTable){
                    $id_admin=$queryTable->getNameAdmin->name??"Không xác định";
                    $id_admin.="<br>";
                    $id_admin.=Carbon::parse($queryTable->updated_at)->format('d/m/Y h:i:s');
                    return $id_admin;
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
                    // $action .= '<a href="' . url('quan-ly/product/update/' . $queryTable->id) . '" class="btn btn-primary btn-round">
                    //  <i class="material-icons">';
                    // $action .= "update";
                    // $action .= '</i></a>';
                    $action.='<button class="btn btn-primary btn-round update_status" value='.$queryTable->id.'>
                    <i class="material-icons">';
                    $action.="block";
                    $action.='</button></i>';
                    $action.='<a href="' . url('quan-ly/orders-details/' . $queryTable->id) . '" class="btn btn-primary btn-round">
                    <i class="material-icons">';
                    $action.="settings";
                    $action.='</i></a>';
                    return $action;
                })
                ->rawColumns(['id', 'dongia', 'trangthai', 'id_khachhang', 'payment', 'id_admin', 'action'])->make('true');
        }
    }
    public function updateStatusOrder(Request  $request,$id)
    {
        try {
          if($request->ajax())
          {  $checkquyen=Auth::guard('admin')->user()->role;
            if($checkquyen == 0)
            {
                return response()->json($this->message('Không có quyền xóa vui lòng liên hệ admin cấp cao',false));

            }
              $query = $this->_model->findOrFailE($id);
              $query->trangthai=$query->trangthai==0?1:0;
              $query->id_admin = Auth::guard('admin')->user()->id;
              $query->updated_at = Carbon::now('Asia/Ho_Chi_Minh');
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
    public function deleteOrder(Request $request , $id)
    {
        if($request->ajax())
        {
            $product=OrderDetailModel::where('id_donhang',$id)->first();

            if($product)
            {
                return response()->json($this->message('Không Thể Xóa Vì Có Chi Tiết Đơn Hàng Liên Quan',false));
            }
            $checkquyen=Auth::guard('admin')->user()->role;
            if($checkquyen == 0)
            {
                return response()->json($this->message('Không có quyền xóa vui lòng liên hệ admin cấp cao',false));

            }
          $this->_model->deleteIdE($id);
           return response()->json($this->message('Xóa Thành Công',true));
        }
    }

}
