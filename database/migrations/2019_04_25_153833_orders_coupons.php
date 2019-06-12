<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersCoupons extends Migration{
    function up(){
        Schema::create('tbl_orders_coupons', function (Blueprint $column){
            $column->increments('id');
            $column->LongText('order_no');
            $column->integer('coupon_id');
            $column->date('order_date');
            $column->Time('order_time');
        });
    }

    function down(){
        Schema::create('tbl_orders_coupons');
    }
}