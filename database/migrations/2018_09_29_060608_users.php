<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration{
    function up(){
        Schema::create('tbl_users', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('varification_code')->unique();
            $column->string('first_name', 15);
            $column->string('last_name', 15);
            $column->LongText('address');
            $column->string('phone_no', 13)->unique();
            $column->string('email', 50);
            $column->string('password', 100);
            $column->string('country_id', 5);
            $column->integer('city_id');
            $column->date('dob');
            $column->LongText('image')->nullable();
            $column->integer('role'); //0 for super admin, 1 for admins, 2 for vendors, 3 for customers
            $column->integer('status'); //0 for active & 1 for pending, 2 for deavtive block.
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_users');
    }
}