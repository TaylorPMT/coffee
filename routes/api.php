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
    Route::group(['prefix' => 'category'], function () {
        Route::get('get','CategorysController@getAll');
    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('get','ProductsController@getAll');
        Route::get('find/{id}','ProductsController@find')->where('id', '[0-9]+');
        Route::get('search/{key}','ProductsController@searchKey')->where('key', '.*');
        Route::get('products-category/{id}','ProductsController@categoryFind')->where('id', '[0-9]+');
    });
    Route::group(['prefix' => 'slideqc'], function () {
        Route::get('get','SlideController@getAll');
    });
    Route::group(['prefix' => 'news'], function () {
        Route::get('get','NewsCategoryController@getAll');
        Route::get('news/{id_dm}','NewsCategoryController@getCategory')->where('id_dm', '[0-9]+');;
    });
    Route::group(['prefix' => 'newsCategory'], function () {
        Route::get('get','NewsCategoryDetailController@getAll');

    });

    Route::group(['prefix' => 'orderCart'], function () {
        Route::post('order','ProductsController@orderCart');
    });
});

Route::group(['middleware' => 'auth.jwt'], function () {
    // phần api viết trong đây
});
