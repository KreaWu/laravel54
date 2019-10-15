<?php

namespace App;

use App\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

//表users
class User extends Authenticatable
{
    //重写fillable
    protected $fillable =[
        'name','email','password'
    ];

    //用户跟文章的关联
    public function posts(){
        return $this->hasMany(\App\Post::class, 'user_id', 'id');
    }

    //用户与粉丝关联
    public function fans(){
        return $this->hasMany(\App\Fan::class, 'star_id', 'id');
    }
    //用户与用户关注的关联
    public function stars(){
        return $this->hasMany(\App\Fan::class, 'fan_id', 'id');
    }


    //关注某人
    public function doFan($uid){
        $fan = new \App\Fan();
        $fan->star_id = $uid;
        return $this->stars()->save($fan);
    }
    //取关某人
    public function doUnfan($uid){
        $fan = new \App\Fan();
        $fan->star_id = $uid;
        return $this->stars()->delete($fan);
    }



    //用户是否被uid关注了
    public function hasFan($uid){
        return $this->fans()->where('fan_id', $uid)->count();
    }

    //用户是否关注了uid
    public function hasStar($uid){
        return $this->stars()->where('star_id', $uid)->count();
    }


    //用户与收到的通知的关联
    public function notices(){
        return $this->belongsToMany(\App\Notice::class, 'user_notice', 'user_id', 'notice_id')->withPivot(['user_id', 'notice_id']);
    }

    //给用户增加通知
    public function addNotice($notice){
        return $this->notices()->save($notice);
    }
    //删除通知
    public function deleteNotice($notice){
        return $this->notices()->detach($notice);
    }
}
