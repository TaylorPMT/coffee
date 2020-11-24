<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\LoginAdmin\RepositoryAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    private $repositoryAdmin;
    public function __construct(RepositoryAdmin $repositoryAdmin)
    {
        $this->repositoryAdmin=$repositoryAdmin;
    }
    public function index()
    {

        return view('BackEnd.login.login');
    }
    public function postLogin(Request $request)
    {

        $data=[
            'email'=>$request->get('email'),
            'password'=>$request->get('password'),
        ];
        $checkLogin=$this->repositoryAdmin->checkLoginAdmin($data);
        if($checkLogin ==true)
        {
            return redirect()->route('admin.dashboard');
        }else

        {
            return redirect()->route('admin.login');
        }

    }
    public function outLogin(Request $request)
    {
        if($this->repositoryAdmin->logoutAdmin())
        {
            return redirect()->route('admin.login');
        }else

        {
            return redirect()->route('admin.login');
        }
    }
}
