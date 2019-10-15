<?php
namespace App\admin\Controllers;
use \App\AdminUser;
use Illuminate\Database\Eloquent\Collection;
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

    //用户角色页面
    public function role(AdminUser $user){
        $roles = \App\AdminRole::all();//获取所有角色
        $myRoles = $user->roles;//当前用户的所有角色

        return view('admin/user/role', compact('roles', 'myRoles', 'user'));
    }
    //存储用户角色
    public function storeRole(\App\AdminUser $user){
        //验证
        $this->validate(request(), [
            'roles'=>'required|array',
        ]);
        //逻辑
        $roles = \App\AdminRole::findMany(request('roles'));//提交上来的所有角色
        $myRoles = $user->roles;//当前用户现有的所有角色

        //以上两者做差集得出要新增的以及要删除的
        //要新增的
        $addroles = $roles->diff($myRoles);
        foreach ($addroles as $addrole){
            $user->assignRole($addrole);
        }
        //要删除的
        $deleteRoles = $myRoles->diff($roles);
        foreach ($deleteRoles as $deleteRole){
            $user->deleteRole($deleteRole);
        }


        //渲染
        return back();

    }
}