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
}
