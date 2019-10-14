<?php
namespace App\admin\Controllers;
use \App\AdminUser;
class UserController extends Controller
{
    //管理人员列表页
    public function index(){
        $users =AdminUser::paginate(2);
        return view('admin/user/index', compact('users'));
    }
    //增加管理人员页面
    public function create(){
        return view('admin/user/add');

    }
    //增加管理人员操作
    public function store(){
        //验证、
        $this->validate(request(), [
            'name'=>'required|min:3',
            'password'=>'required|min:3',
        ]);
        //逻辑
        $name = request('name');
        //对password加密
        $password = bcrypt(request('password'));
        AdminUser::create(compact('name', 'password'));

        //渲染
        return redirect('/admin/users');
    }
}