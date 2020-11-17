<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    //
    protected $table='products';
    protected $fillable = ['name', 'mota','hinhanh','gia','gia_km','trangthai','created_at','updated_at','id_madm'];

    public function getNameCategory(){
        return $this->belongsTo(CategorysModel::class,'id_madm','id');
    }
}
