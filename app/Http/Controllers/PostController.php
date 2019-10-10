<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //列表
    public function index(){
        $posts = Post::orderBy('created_at', 'desc')->paginate(6);
        return view('post/index', compact('posts'));
    }

    //详情
    public function show(Post $post){
        return view('post/show', compact('post'));
    }

    //创建
    public function create(){
        return view('post/create');
    }

    public function store(){



        //1.
        /*$post = new Post();
        $post->title = request('title');
        $post->content = request('content');
        $post->save();*/

        //2.
        /*$param = ['title'=>request('title'), 'content'=>request('content')];
        //上面等价于 $param = request(['title', 'content']);
        Post::create($param);*/

        //3.
        Post::create(request(['title', 'content']));

        return redirect('post/index');

        dd(request()->all());
    }

    //修改
    public function edit(){

    }

    public function update(){

    }

    //删除
    public function delete(){

    }
}
