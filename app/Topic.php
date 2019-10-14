<?php

namespace App;

use App\Model;

class Topic extends Model
{
    //一个专题有多个文章，一个文章也有多个专题（多对多的关系）
    //属于这个专题的所有文章
    public function posts(){
        return $this->belongsToMany(\App\Post::class, 'post_topics', 'topic_id', 'post_id');
    }

    //获取专题的文章数,用于withCount
    public function postTopics(){
        return $this->hasMany(\App\PostTopic::class, 'topic_id', 'id');
    }

}
