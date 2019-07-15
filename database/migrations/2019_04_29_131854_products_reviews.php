<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsReviews extends Migration{
    function up(){
        Schema::create('tbl_products_reviews', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('buyer_ip_address');
            $column->ipAddress('vendor_ip_address');
            $column->integer('buyer_id');
            $column->integer('product_id');
            $column->integer('buyer_stars')->nullable();
            $column->integer('vendor_stars')->nullable();
            $column->LongText('buyer_comment')->nullable();
            $column->LongText('vendor_comment')->nullable();
            $column->date('buyer_review_created_date');
            $column->Time('buyer_review_created_time');
            $column->date('vendor_review_created_date')->nullable();
            $column->Time('vendor_review_created_time')->nullable();
        });
    }

    function down(){
        Schema::dropIfExist('tbl_products_reviews');
    }
}