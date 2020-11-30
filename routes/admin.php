<?php



Route::get('','BackEnd\LoginController@index')->name('admin.login');
Route::post('admin-login-post','BackEnd\LoginController@postLogin')->name('admin.postLogin');

 Route::group(['prefix' => 'quan-ly','namespace'=>'BackEnd','middleware'=>'auth.admin'], function () {
    Route::get('','DashBoardController@index')->name('admin.dashboard');
    Route::get('count-don-hang','DashBoardController@countOrderMonth')->name('admin.countOrderMonth');
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
    //quản lý order
    Route::group(['prefix' => 'order'], function () {
        Route::get('index','OrdersController@index')->name('admin.orderIndex');
        Route::get('getData','OrdersController@getDataAjax')->name('admin.orderAjax');
        // Route::any('save','OrdersController@addProduct')->name('admin.orderSave');
        // Route::any('update/{id}','OrdersController@updateProduct')->name('admin.orderUpdate');
        Route::get('update-status/{id}','OrdersController@updateStatusOrder')->name('admin.orderUpdateStatus');
        // Route::get('orders-details/{id}','OrdersController@updateStatusProduct')->name('admin.orderDetails');
        Route::get('delete/{id}','OrdersController@deleteOrder')->name('admin.orderDelete');
    });
    Route::group(['prefix' => 'orders-details'], function () {
        Route::get('/{id}','OrderdetailsController@index')->name('admin.orderdetailsIndex');
        Route::get('getData/{id}','OrderdetailsController@getDataAjax')->name('admin.orderdetailsAjax');
        // Route::any('save','OrdersController@addProduct')->name('admin.orderSave');
        // Route::any('update/{id}','OrdersController@updateProduct')->name('admin.orderUpdate');
        // Route::get('update-status/{id}','OrderdetailsController@updateStatusOrder')->name('admin.orderUpdateStatus');
        // Route::get('orders-details/{id}','OrdersController@updateStatusProduct')->name('admin.orderDetails');
        Route::get('delete/{id}','OrderdetailsController@deleteOrderdetails')->name('admin.orderdetailsDelete');
    });


    //file manager
    Route::group(['prefix' => 'news'], function () {
        Route::get('index','NewsCategoryController@index')->name('admin.newsCategoryIndex');
        Route::get('getData','NewsCategoryController@getDataAjax')->name('admin.newsCategoryAjax');
        Route::get('delete/{id}','NewsCategoryController@delete')->name('admin.newsCategoryDelete');
        Route::get('update-status/{id}','NewsCategoryController@updateStatus')->name('admin.newsCategoryUpdateStatus');
        Route::any('save','NewsCategoryController@save')->name('admin.newsCategorySave');
        Route::any('update/{id}','NewsCategoryController@update')->name('admin.updateNewsCategory');
    });
    Route::group(['prefix' => 'news-detail'], function () {
        Route::get('{id}','NewsDetailsController@index')->name('admin.newsDetailIndex');
        Route::any('save/{id}','NewsDetailsController@save')->name('admin.newsdetailsSave');
        Route::get('fetch-data/{id}','NewsDetailsController@getDataAjax')->name('admin.newsdetailsFetchIndex');
        Route::get('update-status/{id}','NewsDetailsController@updateStatus')->name('admin.newsdetailsUpdateStatus');
        Route::get('delete/{id}','NewsDetailsController@delete')->name('admin.newsdetailsDelete');
    });
    Route::group(['prefix' => 'banner'], function () {
        Route::get('index','SlideQcContronller@index')->name('admin.bannerIndex');
        Route::get('getData','SlideQcContronller@getData')->name('admin.bannerFetchIndex');
        Route::get('delete/{id}','SlideQcContronller@delete')->name('admin.bannerDelete');
        Route::any('save','SlideQcContronller@save')->name('admin.bannerSave');
        Route::any('update/{id}','SlideQcContronller@update')->name('admin.bannerUpdate');


    });
    Route::group(['prefix' => 'quan-ly-thong-tin'], function () {
        Route::get('quan-ly-thong-tin','AdminController@index')->name('admin.infoIndex');
        Route::post('cap-nhat','AdminController@update')->name('admin.updateProfile');
        Route::get('quan-ly','AdminController@tableadmin')->name('admin.tableadmin');
        Route::get('getData','AdminController@getData')->name('admin.getData');
        Route::get('updateStatus/{id}','AdminController@updateStatus')->name('admin.updateStatus');
        Route::any('update/{id}','AdminController@update_profile')->name('admin.update');
        Route::any('save','AdminController@save')->name('admin.save');

    });
    //Quản lý khách hàng
    Route::group(['prefix' => 'customer'], function () {
        Route::get('index','CustomerController@index')->name('admin.customerIndex');
        Route::get('getData','CustomerController@getDataAjax')->name('admin.customerAjax');
        Route::any('update/{id}','CustomerController@updateCustomer')->name('admin.customerUpdate');
        Route::get('update-status/{id}','CustomerController@updateStatusCustomer')->name('admin.customerUpdateStatus');
    });

 });
 Route::group(['prefix' => 'laravel-filemanager','middleware'=>'auth.admin'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

