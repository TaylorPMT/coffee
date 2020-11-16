<?php
namespace App\Http\Repository\LoginAdmin;
interface InterFaceAdmin {
    public function checkLoginAdmin($array);
    public function logoutAdmin();
}
