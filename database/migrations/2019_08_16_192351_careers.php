<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Careers extends Migration{
    function up(){
        Schema::create('tbl_careers', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->string('name', 50);
            $column->string('email', 50);
            $column->string('job_title', 50);
            $column->string('phone_no', 13);
            $column->longText('message');
            $column->string('cv', 30);
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_careers');
    }
}