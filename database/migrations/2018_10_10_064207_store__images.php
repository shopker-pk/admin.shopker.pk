<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StoreImages extends Migration{
    function up(){
        Schema::create('tbl_store_images', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('store_id');
            $column->string('logo', 50)->nullable();
            $column->string('banner', 50)->nullable();
            $column->string('cheque', 50)->nullable();
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_store_images');
    }
}
