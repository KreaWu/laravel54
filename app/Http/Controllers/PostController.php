<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //列表
    public function index(){
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('post/index', compact('posts'));
    }

    //详情
    public function show(){

    }

    //创建
    public function create(){

    }

    public function store(){

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
