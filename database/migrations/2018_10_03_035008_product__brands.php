<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductBrands extends Migration{
    function up(){
        Schema::create('tbl_product_brands', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('user_id');
            $column->integer('product_id');
            $column->integer('brand_id');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_product_brands');
    }
}
