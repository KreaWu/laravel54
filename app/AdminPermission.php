<?php

namespace App;

use App\Model;

class AdminPermission extends Model
{
    //修改表名
    protected $table = 'admin_permissions';

    //权限与角色关联
    public function roles(){
        return $this->belongsToMany(\App\AdminRole::class, 'admin_role_permission', 'permission_id', 'role_id')->withPivot(['permission_id', 'role_id']);
    }


}
