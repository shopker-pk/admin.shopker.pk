<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CouponsProducts extends Migration{
    function up(){
        Schema::create('tbl_coupons_products', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('admin_id');
            $column->integer('vendor_id');
            $column->integer('coupon_id');
            $column->integer('product_id');
            $column->date('created_date');
            $column->time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_coupons_products');
    }
}