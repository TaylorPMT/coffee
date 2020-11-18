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

class OrderdetailsController extends Controller
{
    public $_controllerName = "Quản Lý Chi Tiết Đơn Hàng ";
    public $_controllersDes = "Quản Lý Chi Tiết Đơn Hàng ";
    public $_root = 'BackEnd/pages/orders_details/';
    protected $_model;
    public function __construct(OrderDetailModel $OrderDetailModel)
    {
        $this->_model = new RepositoryHome($OrderDetailModel);
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
    public function index($id)
    {
        return view($this->_root . 'index',compact('id'));
    }
    public function getDataAjax(Request $request, $id)
    {
        if ($request->ajax()) {
            $queryTable = OrderDetailModel::where('id_donhang',$id)->get();
            return DataTables::of($queryTable)
                ->addColumn('id', function ($queryTable) {
                    $id = $queryTable->id;
                    return $id;
                })->addColumn('id_donhang', function ($queryTable) {
                    $id_donhang = $queryTable->id_donhang;
                    return $id_donhang;
                })->addColumn('id_sanpham', function ($queryTable) {
                    $id_sanpham = $queryTable->getNameProduct->name;
                    return $id_sanpham;
                })->addColumn('soluong', function ($queryTable) {
                    $soluong = $queryTable->soluong;
                    return $soluong;
                })->addColumn('dongia',function($queryTable){
                    $dongia = number_format($queryTable->dongia,0,',','.').' VNĐ';
                    return $dongia;
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
                    // $action='<button  class="btn btn-primary btn-round update_status" value='.$queryTable->id.'>
                    // <i class="material-icons">';
                    // $action.="block";
                    // $action.='</button></i>';
                    // $action.='<a href="' . url('quan-ly/orders-details/' . $queryTable->id) . '" class="btn btn-primary btn-round">
                    // <i class="material-icons">';
                    // $action.="settings";
                    // $action.='</i></a>';
                    return $action;
                })
                ->rawColumns(['id', 'id_donhang', 'id_sanpham', 'soluong', 'tongtien','action'])->make('true');
        }
    }
    public function deleteOrderdetails(Request $request , $id)
    {
        if($request->ajax())
        {
          $this->_model->deleteIdE($id);
           return response()->json($this->message('Xóa Thành Công',true));
        }
    }

}
