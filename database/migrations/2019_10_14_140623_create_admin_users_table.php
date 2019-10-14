<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //AdminUser表（大写与驼峰式）
        Schema::create('admin_users', function (Blueprint $table){
            $table->increments('id');
            $table->string('name', 30);
            $table->string('password', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        //回滚数据库
        Schema::dropIfExists('admin_users');
    }
}
