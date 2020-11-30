<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
use App\Models\OrderDetailModel;
use App\Models\OrderModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
if(!defined('STATUS_ACTIVE'))define('STATUS_ACTIVE',1);
class ProductsController extends Controller
{
    //
    protected $_model;
    public function __construct(ProductModel $ProductModel)
    {
        $this->_model=new RepositoryHome($ProductModel);


    }
    public function getAll(Request $request)
    {
        return response()->json($this->_model->whereE([['trangthai','=',STATUS_ACTIVE]]));
    }
    public function find(Request $request , $id_product)
    {
        return response()->json($this->_model->whereE([['id','=',$id_product],['trangthai','=',STATUS_ACTIVE]]));
    }
    public function searchKey(Request $request,$key)
    {
        return response()->json($this->_model->searchLikeE('name',$key));
    }
    public function categoryFind(Request $request , $id_madm)
    {
        return response()->json($this->_model->whereE([['id_madm','=',$id_madm],['trangthai','=',STATUS_ACTIVE]]));
    }
    public function orderCart(Request $request)
    {
        // pram
        $rules=[
            'dongia'=>'required',
            'trangthai'=>'required',
            'id_khachhang'=>'required',
            'payment'=>'required',
            'orderDeail'=>'required',


        ];
        $valator= validator()->make($request->all(),$rules,[

        ]);
        if($valator->fails())
        {
            return response()->json(['message'=>false,'data'=>$valator]);
        }
        $dataAdd=[
            'dongia'=>$request->dongia,
            'trangthai'=>$request->trangthai,
            'id_khachhang'=>$request->id_khachhang,
            'payment'=>$request->payment,

        ];
        $createOrder=OrderModel::create($dataAdd);
        foreach ($request->orderDeail as $value)
        {
            $dataOrderDetail =[
                'soluong'=>$value['soluong'],
                'dongia'=>$value['dongia'],
                'id_donhang'=>$createOrder->id,
                'id_sanpham'=>$value['id_sanpham'],
            ];
            $createOrderDetail = OrderDetailModel::create($dataOrderDetail);

        }
        return response()->json(['message'=>true,'data'=>'Đặt Hàng Thành Công']);

    }
}
