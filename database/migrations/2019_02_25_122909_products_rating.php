<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsRating extends Migration{
    function up(){
        Schema::create('tbl_products_rating', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('buyer_id');
            $column->integer('product_id');
            $column->integer('stars')->nullable();
            $column->LongText('buyer_comment')->nullable();
            $column->LongText('vendor_comment')->nullable();
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_products_rating');
    }
}
