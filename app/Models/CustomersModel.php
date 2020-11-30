<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomersModel extends Model
{
    //
    protected $table='customers';
    protected $fillable = ['id','ten','email','password','diachi','sdt','ghichu','trangthai','created_at','updated_at'];
}
