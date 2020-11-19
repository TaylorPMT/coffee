<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|*/
Route::group(['namespace' => 'FrontEnd'], function () {
    Route::post('login','LoginApiController@login');
    Route::post('register','LoginApiController@register');
});
Route::group(['middleware' => 'auth.jwt'], function () {
    // phần api viết trong đây
});
