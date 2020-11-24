<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    //
    use Notifiable;
    protected $guard='admin';
    protected $table="admin";
    protected $fillable=['name','email','sdt','role','trangthai','diachi','email_verified_at','password'];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */


}
