<?php

namespace App;

use App\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    //由于adminuser没有is_remember字段，因此需要重写Illuminate\Foundation\Auth\User中的Authenticatable类中的protected $rememberTokenName这个字段；

    protected $rememberTokenName='';//重写基类中的这个字段，设置为空即可
}
