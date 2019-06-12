<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiteShippingCharges extends Migration{
    function up(){
        Schema::create('tbl_site_shipping_charges', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('admin_id');
            $column->integer('per_kg_0')->nullable(); //withing city
            $column->integer('half_kg_0')->nullable(); //withing city
            $column->integer('per_kg_1')->nullable(); //outside city
            $column->integer('half_kg_1')->nullable(); //outside city
            $column->integer('additional_per_kg_0')->nullable(); //withing city
            $column->integer('additional_per_kg_1')->nullable(); //outside city
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_site_shipping_charges');
    }
}