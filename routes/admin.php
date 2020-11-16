<?php


Route::get('','BackEnd\LoginController@index')->name('admin.login');
Route::post('admin-login-post','BackEnd\LoginController@postLogin')->name('admin.postLogin');

 Route::group(['prefix' => 'quan-ly','namespace'=>'BackEnd','middleware'=>'auth.admin'], function () {
    Route::get('','DashBoardController@index')->name('admin.dashboard');
    //route logout
    Route::get('login-out','LoginController@outLogin')->name('admin.logout');
    //quản lý banner
    Route::group(['prefix' => 'category'], function () {
        Route::get('index','CategorysController@index')->name('admin.categoryIndex');
        Route::get('getData','CategorysController@getDataAjax')->name('admin.categoryAjax');

        Route::get('delete/{id}','CategorysController@deleteCategory')->name('admin.categoryDelete');
    });

    //file manager

    Route::group(['prefix' => 'quan-ly-thong-tin'], function () {
        Route::get('quan-ly-thong-tin','AdminController@index')->name('admin.infoIndex');
        Route::post('cap-nhat','AdminController@update')->name('admin.updateProfile');
    });
 });
 Route::group(['prefix' => 'laravel-filemanager','middleware'=>'auth.admin'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

