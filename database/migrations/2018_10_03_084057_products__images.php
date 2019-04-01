<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsImages extends Migration{
    function up(){
        Schema::create('tbl_products_images', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('user_id');
            $column->integer('product_id');
            $column->string('image', 50);
        });
    }

    function down(){
        Schema::dropIfExist('tbl_products_images');
    }
}
