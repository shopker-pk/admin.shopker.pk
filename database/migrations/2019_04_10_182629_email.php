<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Email extends Migration{
    function up(){
        Schema::create('tbl_emails', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->LongText('name');
            $column->string('email', 50);
            $column->LongText('subject');
            $column->string('phone_no', 13);
            $column->LongText('message');
            $column->integer('type'); // 0 for whole sale, 1 for contac us emails. 
            $column->date('created_date');
            $column->time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_emails');
    }
}