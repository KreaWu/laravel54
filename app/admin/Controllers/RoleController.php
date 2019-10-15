<?php
namespace App\admin\Controllers;

use \App\AdminRole;

class RoleController extends Controller
{
    //角色页面
    public function index(){
        $roles = \App\AdminRole::paginate(5);
        return view('admin/role/index', compact('roles'));

    }
    //添加角色
    public function create(){
        return view('admin/role/add');

    }
    //保存添加的角色
    public function store(){
        $this->validate(request(), [
            'name'=>'required|min:3',
            'description'=>'required',

        ]);

        AdminRole::create(request(['name', 'description']));

        return redirect('/admin/roles');

    }

    //角色权限页面
    public function permission(\App\AdminRole $role){
        //dd($adminRole);
        //获取所有权限
        $permissions = \App\AdminPermission::all();
        //获取当前角色的所有权限
        $myPermissions = $role->permissions;
        return view('admin/role/permission', compact('permissions', 'myPermissions', 'role'));
    }
    //存储角色权限
    public function storePermission(AdminRole $role){
        $this->validate(request(),[
            'permissions'=>'required|array',
        ]);

        //获取提交上来的权限
        $permissions = \App\AdminPermission::findMany(request('permissions'));
        //获取当前角色已有的权限
        $myPermissions = $role->permissions;

        //对以上两者作差集，得出需要增加和删除的
        //需要增加的
        $addPermissions = $permissions->diff($myPermissions);
        foreach ($addPermissions as $addPermission){
            $role->grantPermission($addPermission);
        }
        //需要删除的
        $deletePermissions = $myPermissions->diff($permissions);
        foreach ($deletePermissions as $deletePermission){
            $role->deletePermission($deletePermission);
        }

        return back();

    }
}
