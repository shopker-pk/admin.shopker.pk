<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration{
    function up(){
        Schema::create('tbl_orders', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('seller_id');
            $column->integer('buyer_id');
            $column->LongText('order_no');
            $column->integer('product_id');
            $column->integer('quantity');
            $column->integer('product_amount');
            $column->integer('type');
            $column->integer('payment_method'); //0 for Jazz Cash, 1 for Easy Paisa & 2 Cash On Delivery
            $column->integer('status'); //0 for Pending, 1 for In Process, 2 for Ready to ship, 3 for shipped, 4 Delivered & 5 Canceled
            $column->date('order_date');
            $column->Time('order_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_orders');
    }
}