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

        //以下页面需要有权限才能使用，
        //根据在app/provider/authServiceprovider.php的boot中注册的每个权限的门卫，对以下页面进行使用

        //system权限可以操作以下页面
        Route::group(['middleware' => 'can:system'], function (){
            //管理人员列表
            //增加管理人员
            //执行增加管理人员
            //用户角色关联页面
            //存储用户角色
            Route::get('/users','\App\admin\Controllers\UserController@index');
            Route::get('/users/create','\App\admin\Controllers\UserController@create');
            Route::post('/users/store','\App\admin\Controllers\UserController@store');
            Route::get('/users/{user}/role','\App\admin\Controllers\UserController@role');
            Route::post('/users/{user}/role','\App\admin\Controllers\UserController@storeRole');

            //角色
            Route::get('/roles','\App\admin\Controllers\RoleController@index');
            Route::get('/roles/create','\App\admin\Controllers\RoleController@create');
            Route::post('/roles/store','\App\admin\Controllers\RoleController@store');
            //角色与权限关系页
            //存储角色权限
            Route::get('/roles/{role}/permission','\App\admin\Controllers\RoleController@permission');
            Route::post('/roles/{role}/permission','\App\admin\Controllers\RoleController@storePermission');

            //权限
            Route::get('/permissions','\App\admin\Controllers\PermissionController@index');
            Route::get('/permissions/create','\App\admin\Controllers\PermissionController@create');
            Route::post('/permissions/store','\App\admin\Controllers\PermissionController@store');


        });

        //文章权限
        Route::group(['middleware'=>'can:post'], function (){
            //文章列表
            //文章审核操作
            Route::get('/posts','\App\admin\Controllers\PostController@index');
            Route::post('/posts/{post}/status','\App\admin\Controllers\PostController@status');
        });


    });
});