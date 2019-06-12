<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShippingCharges extends Migration{
    function up(){
        Schema::create('tbl_shipping_charges', function (Blueprint $column){
            $column->increments('id');
            $column->LongText('order_no');
            $column->integer('charges');
            $column->date('order_date');
            $column->Time('order_time');
        });
    }

    function down(){
        Schema::dropIfEixst('tbl_shipping_charges');
    }
}