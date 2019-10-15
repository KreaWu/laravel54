<?php

namespace App;

use App\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    //重写fillable
    protected $fillable =[
        'name','password'
    ];
    //由于adminuser没有is_remember字段，因此需要重写Illuminate\Foundation\Auth\User中的Authenticatable类中的protected $rememberTokenName这个字段；

    protected $rememberTokenName='';//重写基类中的这个字段，设置为空即可

    //用户与角色关联，用户的所有角色（多对多）
    //withPivot取出中间表信息
    public function roles(){
        return $this->belongsToMany(\App\AdminRole::class, 'admin_role_user', 'user_id', 'role_id')->withPivot(['user_id', 'role_id']);
    }

    //某个用户是否有某个/些角色（一对多）
    //$this->roles  获取用户的所有角色
    //intersect  做交集(集合的关系)
    //传入的参数$roles是一个查询结果对象
    public function isInRoles($roles){
        return !!$roles->intersect($this->roles)->count();  //!!强制返回bool值
    }

    //给用户分配角色
    public function assignRole($role){
        return $this->roles()->save($role);
    }

    //取消用户角色
    public function deleteRole($role){
        return $this->roles()->detach($role);
    }

    //用户是否有某个权限
    public function hasPermission($permission){
        //用户的角色与权限的角色做交集
        return $this->isInRoles($permission->roles);
    }
}
