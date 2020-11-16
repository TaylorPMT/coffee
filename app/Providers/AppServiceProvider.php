<?php

namespace App\Providers;

use App\Http\Repository\Home\InterFaceHome;
use App\Http\Repository\Home\RepositoryHome;
use App\Http\Repository\LoginAdmin\InterFaceAdmin;
use App\Http\Repository\LoginAdmin\RepositoryAdmin;
use App\Http\Repository\UploadImage\InterFaceUpload;
use App\Http\Repository\UploadImage\RepositoryUploadImage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(InterFaceAdmin::class,RepositoryAdmin::class);
        $this->app->singleton(InterFaceUpload::class,RepositoryUploadImage::class);
       // $this->app->singleton(InterFaceHome::class,RepositoryHome::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('*',function($view){


        });
    }
}
