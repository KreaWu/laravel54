<?php
namespace App\admin\Controllers;

use \App\Post;

class PostController extends Controller
{
    //文章管理列表
    public function index(){
        $posts = Post::withoutGlobalScope('avaiable')->where('status', 0)->orderBy('created_at', 'desc')->paginate(10);//表明不使用叫avaiable的全局范围
        return view('/admin/post/index', compact('posts'));
    }

    public function status(Post $post){
        //验证
        $this->validate(request(), [
            'status'=>'required|in:-1,1',
        ]);
        //保存状态
        $post->status = request('status');
        $post->save();
        //返回
        return [
            'error'=>0,
            'msg'=>''
        ];
    }

}