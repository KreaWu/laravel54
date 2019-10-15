<?php

namespace App;

use App\Model;

class AdminRole extends Model
{
    //修改表名
    protected $table = 'admin_roles';

    //角色与权限的管理
    public function permissions(){
        return $this->belongsToMany(\App\AdminPermission::class, 'admin_role_permission', 'role_id', 'permission_id')->withPivot(['role_id', 'permission_id']);
    }

    //给角色授予权限
    public function grantPermission($permission){
        return $this->permissions()->save($permission);
    }

    //给角色取消权限
    public function deletePermission($permission){
        return $this->permissions()->detach($permission);
    }

    //角色是否包含某个权限
    //
    public function haspermissions($permission){
        return $this->permissions->contains($permission);
    }
}
