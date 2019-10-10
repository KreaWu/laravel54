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
        //验证
        $this->validate(request(), [
            'title'=>'required|string|max:100|min:5',
            'content'=>'required|string|min:10',
        ]);

        //存储
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

        //跳转
        return redirect('/posts');

    }

    //修改
    public function edit(Post $post){
        return view('post/edit', compact('post'));

    }

    public function update(Post $post){
    //验证
        $this->validate(request(), [
            'title'=>'required|string|max:100|min:5',
            'content'=>'required|string|min:10',
        ]);
    //保存
        $post->title = request('title');
        $post->content = request('content');
        $post->save();
    //渲染
        return redirect("/posts/{$post->id}");
    }

    //删除
    public function delete(Post $post){
        //TODO:用户权限验证

        $post->delete();
        return redirect('/posts');
    }


    //上传图片
    public function imageUpload(Request $request){
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/'.$path);
    }
}
