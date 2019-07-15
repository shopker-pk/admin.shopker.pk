<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShippingAreas extends Migration{
    function up(){
        Schema::create('tbl_shipping_areas', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('user_id');
            $column->integer('shipping_charges')->nullable();
            $column->integer('parent_id')->nullable();
            $column->string('country_id', 5)->nullable();
            $column->integer('city_id')->nullable();
            $column->integer('status');
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_shipping_areas');
    }
}
