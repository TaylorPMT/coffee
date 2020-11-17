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
        Route::any('save','CategorysController@addCategory')->name('admin.categorySave');
        Route::any('update/{id}','CategorysController@updateCategory')->name('admin.categoryUpdate');
        Route::get('delete/{id}','CategorysController@deleteCategory')->name('admin.categoryDelete');
    });
    //quản lý product
    Route::group(['prefix' => 'product'], function () {
        Route::get('index','ProductsController@index')->name('admin.productIndex');
        Route::get('getData','ProductsController@getDataAjax')->name('admin.productAjax');
        Route::any('save','ProductsController@addProduct')->name('admin.productSave');
        Route::any('update/{id}','ProductsController@updateProduct')->name('admin.productUpdate');
        Route::get('update-status/{id}','ProductsController@updateStatusProduct')->name('admin.productUpdateStatus');
        Route::get('delete/{id}','ProductsController@deleteProduct')->name('admin.productDelete');
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

