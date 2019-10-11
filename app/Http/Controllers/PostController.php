<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //列表
    public function index(){
        //withCount("comments")获取评论数
        $posts = Post::orderBy('created_at', 'desc')->withCount('comments')->paginate(6);
        return view('post/index', compact('posts'));
    }

    //详情
    public function show(Post $post){
        //评论预加载，利于前端view层优化
        $post->load('comments');
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
        //获取用户id
        $user_id = \Auth::id();//当前登录用户id
        $param = array_merge(request(['title', 'content']), compact('user_id'));
        Post::create($param);

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

    //策略判断，判断是否有权限进行修改
        $this->authorize('update',$post);
    //保存
        $post->title = request('title');
        $post->content = request('content');
        $post->save();
    //渲染
        return redirect("/posts/{$post->id}");
    }

    //删除
    public function delete(Post $post){
        //用户权限验证
        $this->authorize('delete',$post);
        $post->delete();
        return redirect('/posts');
    }


    //上传图片
    public function imageUpload(Request $request){
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/'.$path);
    }

    //提交评论
    public function comment(Post $post){
    //验证
        $this->validate(request(), [
            'content'=>'required|min:3',
        ]);
    //逻辑
        $comment = new Comment();
        $comment->user_id = \Auth::id();
        $comment->content = request('content');
        //将post关联模型保存进去(保存一个post评论)
        $post->comments()->save($comment);

    //渲染
        return back();//返回上一页，即文章详情页
    }
}
