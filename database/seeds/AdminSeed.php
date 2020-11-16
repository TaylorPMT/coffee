<?php

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admins=[

                'email'=>'admin@gmail.com',
                'password'=>bcrypt(123456),
                'name'=>'Dev',

                'sdt'=>'1213321321',
                'role'=>1,
                'trangthai'=>1,
                'diachi'=>'Địa Chỉ',
                'email_verified_at'=>Carbon::now(),


        ];

                Admin::create($admins);

    }
}
