<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LoginActivities extends Migration{
    function up(){
        Schema::create('tbl_login_activities', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('user_id');
            $column->integer('status');
            $column->date('date');
            $column->Time('time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_login_activities');
    }
}
