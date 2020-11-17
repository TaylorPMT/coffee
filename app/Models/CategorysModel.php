<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorysModel extends Model
{
    //
    protected $table='categorys';
    protected $fillable =['name','created_at','updated_at'];

}
