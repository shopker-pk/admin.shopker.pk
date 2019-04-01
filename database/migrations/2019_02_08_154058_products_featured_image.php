<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsFeaturedImage extends Migration{
    function up(){
        Schema::create('tbl_products_featured_images', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('user_id');
            $column->string('featured_image', 50);
            $column->integer('product_id');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_products_featured_images');
    }
}