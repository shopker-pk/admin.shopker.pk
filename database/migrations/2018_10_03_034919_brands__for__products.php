<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BrandsForProducts extends Migration{
    function up(){
        Schema::create('tbl_brands_for_products', function (Blueprint $column){
            $column->increments('id');
            $column->integer('user_id');
            $column->ipAddress('ip_address');
            $column->string('image', 50)->nullable();
            $column->longText('name');
            $column->longText('slug');
            $column->integer('status');
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_brands_for_products');
    }
}
