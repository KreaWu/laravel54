<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    //
    public function show(Topic $topic){
        //获取带文章数的专题信息
        $topic= Topic::withCount('postTopics')->find($topic->id);
        //获取专题的文章列表，前10个
        $posts = $topic->posts()->orderBy('created_at', 'desc')->take(10)->get();

        //获取属于我的文章，但未投到该专题
        //属于我的（在post模型中用scope已经定义）
        $myposts = \App\Post::authorBy(\Auth::id());
        //并且未投稿至某个专题(在post模型中用scope已经定义)
        $myposts = $myposts->topicNotBy($topic->id)->get();


        return view('topic/show', compact('topic', 'posts','myposts'));
    }

    public function submit(Topic $topic){
        //验证
        $this->validate(request(), [
            'post_ids'=>'required|array',
        ]);
        //逻辑,在PostTopics中新增投稿的数据
        $post_ids = request('post_ids');
        $topic_id = $topic->id;
        foreach ($post_ids as $post_id) {
            \App\PostTopic::firstOrCreate(compact('post_id', 'topic_id'));

        }

        //渲染
        return back();

    }
}
