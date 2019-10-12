<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //个人设置页面
    public function setting(){
        return view('user/setting');
    }
    //设置行为
    public function settingStore(){

    }

    //个人中心
    public function show(User $user){
        //往页面传递个人信息：关注/粉丝/文章数，需要用到withCount,withCount只能在queryBuilder中使用，因此要
        $user = User::withCount(['fans', 'posts', 'stars'])->find($user->id);

        //传递个人的文章，前10条
        $posts = $user->posts()->orderBy('created_at', 'desc')->take(10)->get();

        //获取关注人的信息：关注/粉丝/文章数
        $stars = $user->stars;//获取所有的关注的人
        $susers = User::whereIn('id', $stars->pluck('star_id'))->withCount(['fans', 'posts', 'stars'])->get();

        //获取粉丝的信息：关注/粉丝/文章数
        $fans = $user->fans;//获取所有的粉丝
        $fusers = User::whereIn('id', $fans->pluck('fan_id'))->withCount(['fans', 'posts', 'stars'])->get();//所有粉丝的信息，且通过user对象可以获取各个数量；
        //$fans = $user->fans()->withCount(['fans', 'posts', 'stars']);


        return view('user/show', compact('user', 'posts', 'fusers', 'susers'));
    }

    //关注
    public function fan(User $user){
        //获取当前用户
        $me = \Auth::user();
        $me->dofan($user->id);
        return [
            'error'=>0,
            'msg'=>'',
        ];

    }

    //取关
    public function unfan(User $user){
        //获取当前用户
        $me = \Auth::user();
        $me->doUnfan($user->id);
        return [
            'error'=>0,
            'msg'=>'',
        ];
        //return "ceshi";
    }
}
