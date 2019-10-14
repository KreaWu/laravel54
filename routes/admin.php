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
    });
});