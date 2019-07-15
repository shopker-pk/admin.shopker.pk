<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VariationsForProducts extends Migration{
    function up(){
        Schema::create('tbl_variations_for_products', function (Blueprint $column){
            $column->increments('id');
            $column->integer('user_id');
            $column->ipAddress('ip_address');
            $column->longText('label');
            $column->longText('value');
            $column->integer('status');
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_variations_for_products');
    }
}
