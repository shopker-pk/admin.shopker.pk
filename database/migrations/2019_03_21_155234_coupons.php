<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Coupons extends Migration{
    function up(){
        Schema::create('tbl_coupons', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('admin_id')->nullable();
            $column->integer('vendor_id')->nullable();
            $column->string('code', 30)->unique();
            $column->integer('discount_type');
            $column->date('start_date');
            $column->date('end_date');
            $column->string('discount_offer', 15);
            $column->integer('no_of_uses');
            $column->string('min_order_amount', 15);
            $column->string('max_order_amount', 15);
            $column->integer('limit_per_customer');
            $column->integer('order_type');
            $column->integer('status');
            $column->date('created_date');
            $column->time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_coupons');
    }
}