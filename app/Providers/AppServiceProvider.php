<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    //所有的页面都会进入AppServiceProvider
    //boot()在所有serviceprovider注册前调用，
    //register()在所有的service provider注册后调用
    public function boot()
    {
        //注入视图组合器(由于每个页面都会有专题，因此在这边直接将topic数据注入每个页面)
        \View::composer('layout.sidebar', function ($view){
           $topics = \App\Topic::all();
            $view->with('topics',$topics);
        });

    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
