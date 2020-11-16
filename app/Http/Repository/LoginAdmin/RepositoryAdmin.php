<?php
namespace App\Http\Repository\LoginAdmin;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class RepositoryAdmin implements InterFaceAdmin {
    private $model;
    public function __construct(Admin $admin)
    {
        $this->model=$admin;
    }
    public function checkLoginAdmin($array)
    {

        if(Auth::guard('admin')->attempt($array))
        {
           return true;
        }else
        {
            return false;

        }
    }
    public function logoutAdmin()
    {
        if(Auth::guard('admin')->check())
        {
            Auth::guard('admin')->logout();
            session()->flush();
            return true;

        }else
        {
            return false;

        }
    }
}
