<?php
namespace App\admin\Controllers;

use \App\AdminPermission;

class PermissionController extends Controller
{
    //权限页面
    public function index(){
        $permissions = AdminPermission::paginate(5);
        return view('admin/permission/index', compact('permissions'));

    }
    //添加权限
    public function create(){
        return view('admin/permission/add');

    }
    //保存添加的权限
    public function store(){
        $this->validate(request(), [
            'name'=>'required|min:3',
            'description'=>'required',
        ]);

        AdminPermission::create(request(['name', 'description']));

        return redirect('/admin/permissions');

    }

}