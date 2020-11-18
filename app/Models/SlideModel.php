<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlideModel extends Model
{
    //
    protected $table='slideqc';
    protected $fillable=[
        'link',
        'image',
        'id_admin'
    ];
}
