<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    //
    protected $table='order';
    protected $fillable = ['id','dongia','trangthai','id_khachhang','payment','created_at','updated_at','id_admin'];
    public function getNameCustomer(){
        return $this->belongsTo(CustomersModel::class,'id_khachhang','id');
    }
    public function getNameAdmin(){
        return $this->belongsTo(Admin::class,'id_admin','id');

    }
}
