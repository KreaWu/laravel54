<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;


class Model extends BaseModel
{
    //
    protected $guarded = []; //不可注入字段，设置为空，即都可通过数组注入；
    //protected $fillable = ['title', 'content']; //可注入字段，
}