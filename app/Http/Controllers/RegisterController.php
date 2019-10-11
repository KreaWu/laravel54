<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //注册页面
    public function index(){
        return view('register/index');

    }
    //注册行为
    public function register(){

        //验证
        $this->validate(request(), [
            'name'=>'required|unique:users,name|min:3',
            'email'=>'required|unique:users,email|email',
            'password'=>'required|min:5|max:20|confirmed'

        ]);
        //逻辑插入
        $name = request('name');
        $email = request('email');
        //对password加密
        $password = bcrypt(request('password'));
        $user = User::create(compact('name','password', 'email'));
        //渲染
        return redirect('/login');

    }
}
