<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cities extends Migration{
    function up(){
        Schema::create('tbl_cities', function(Blueprint $column){
            $column->increments('id');
            $column->LongText('country_id');
            $column->LongText('city_id');
            $column->longText('name');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_cities');
    }
}