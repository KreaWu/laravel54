<?php

namespace App;

use App\Model;
use Laravel\Scout\Searchable;

//表posts
class Post extends Model
{
    use Searchable;
    //定义索引里面的type
    public function searchableAs()
    {
        return 'post';
    }
    //定义有哪些字段需要搜索
    public function toSearchableArray()
    {
        return [
            'title'=>$this->title,
            'content'=>$this->content,
        ];
    }

    //以下设置在model基类中已经设置，该model基类为自己写的，并继承了laravel的model基类
    //protected $guarded = []; //不可注入字段，设置为空，即都可通过数组注入；
    //protected $fillable = ['title', 'content']; //可注入字段，

    //文章关联作者(一对多的反向)
    public function user(){
        return $this->belongsTo('App\User');
    }

    //文章关联评论模型
    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }

    //关联一个用户对一个文章只能一个赞(判断用户是否赞过,返回一个赞)

    public function zan($user_id){
        return $this->hasOne(\App\Zan::class)->where('user_id',$user_id);
    }

    //获取该文章的赞数量
    public function zans(){
        return $this->hasMany(\App\Zan::class);
    }
}
