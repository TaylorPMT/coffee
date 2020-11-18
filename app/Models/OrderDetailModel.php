<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetailModel extends Model
{
    //
    protected $table='order_detail';
    public function getNameProduct(){
        return $this->belongsTo(ProductModel::class,'id_sanpham','id');

    }
}
