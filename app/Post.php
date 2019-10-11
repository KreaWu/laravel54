<?php

namespace App;

use App\Model;

//表posts
class Post extends Model
{
    //以下设置在model基类中已经设置，该model基类为自己写的，并继承了laravel的model基类
    //protected $guarded = []; //不可注入字段，设置为空，即都可通过数组注入；
    //protected $fillable = ['title', 'content']; //可注入字段，

    //文章关联作者
    public function user(){
        return $this->belongsTo('App\User');
    }
}
