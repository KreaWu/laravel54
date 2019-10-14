<?php
//后台管理
Route::group(['prefix'=>'admin'], function (){
    Route::get('/', function () {
        return view('admin/welcome');
    });
    //登录页面
    Route::get('/login','\App\admin\Controllers\LoginController@index');
    //登录行为
    Route::post('/login','\App\admin\Controllers\LoginController@login');
    //登出页面
    Route::get('/logout','\App\admin\Controllers\LoginController@logout');
    Route::group(['middleware'=>'auth:admin'], function (){
        //首页
        Route::get('/home','\App\admin\Controllers\HomeController@index');

        //管理人员列表
        Route::get('/users','\App\admin\Controllers\UserController@index');

        //增加管理人员
        Route::get('/users/create','\App\admin\Controllers\UserController@create');

        //执行增加管理人员
        Route::post('/users/store','\App\admin\Controllers\UserController@store');

        //文章列表
        Route::get('/posts','\App\admin\Controllers\PostController@index');

        //文章审核操作
        Route::post('/posts/{post}/status','\App\admin\Controllers\PostController@status');

    });
});