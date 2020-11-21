<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
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
}
