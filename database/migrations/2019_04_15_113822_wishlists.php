<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Wishlists extends Migration{
    function up(){
        Schema::create('tbl_wishlists', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('user_id');
            $column->integer('product_id');
            $column->date('created_date');
            $column->time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_wishlists');
    }
}