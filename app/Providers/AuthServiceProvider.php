<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        'App\Post'=>'App\Policies\PostPolicy',//注册文章权限策略类
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //对每一个权限定义门卫
        $permissions = \App\AdminPermission::all();
        foreach ($permissions as $permission){
            Gate::define($permission->name, function ($user) use($permission){
               return $user->hasPermission($permission);
            });
        }

    }
}
