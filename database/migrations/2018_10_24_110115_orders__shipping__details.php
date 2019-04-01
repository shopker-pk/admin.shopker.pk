<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersShippingDetails extends Migration{
    function up(){
        Schema::create('tbl_orders_shipping_details', function (Blueprint $column){
            $column->increments('id');
            $column->LongText('order_no');
            $column->string('name');
            $column->string('contact_no');
            $column->integer('city_id');
            $column->string('country_id', 55);
            $column->LongText('address');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_orders_shipping_details');
    }
}
