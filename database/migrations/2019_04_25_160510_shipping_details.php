<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShippingDetails extends Migration{
    function up(){
        Schema::create('tbl_shipping_details', function (Blueprint $column){
            $column->increments('id');
            $column->longText('order_no');
            $column->string('first_name', 30);
            $column->string('last_name', 30);
            $column->string('email', 50);
            $column->string('phone_no', 13);
            $column->string('country', 20);
            $column->string('city', 20);
            $column->string('area', 20);
            $column->longText('address');
            $column->date('order_date');
            $column->Time('order_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_shipping_details');
    }
}