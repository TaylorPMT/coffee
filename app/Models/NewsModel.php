<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    //
    protected $table="news";
    protected $fillable=[
        'tieude',
        'noidung',
        'image',
        'tacgia',
        'id_dmtintuc',
        'id_admin',
    ];
}
