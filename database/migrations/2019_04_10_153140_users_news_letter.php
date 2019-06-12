<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersNewsLetter extends Migration{
    function up(){
        Schema::create('tbl_users_news_letter', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('user_id');
            $column->integer('news_letter')->default(1);
            $column->date('created_date');
            $column->time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_users_news_letter');
    }
}