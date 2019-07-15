<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderDeliveryCharges extends Migration{
    function up(){
        Schema::create('tbl_order_delivery_charges', function (Blueprint $column){
            $column->increments('id');
            $column->LongText('order_no');
            $column->integer('charges');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_order_delivery_charges');
    }
}