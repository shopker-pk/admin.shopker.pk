<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductCategories extends Migration{
    function up(){
        Schema::create('tbl_product_categories', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('user_id');
            $column->integer('product_id');
            $column->integer('parent_id');
            $column->integer('child_id');
            $column->integer('sub_child_id');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_product_categories');
    }
}
