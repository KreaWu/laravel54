<?php

namespace App;

use App\Model;

class Comment extends Model
{
    //文章对评论（一对多的反向)
    public function post(){
        return $this->belongsTo('App\Post');
    }

    //评论的用户关联评论（一对多的反向)
    public function user(){
        return $this->belongsTo('App\User');
    }

}
