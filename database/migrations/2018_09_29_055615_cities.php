<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cities extends Migration{
    function up(){
        Schema::create('tbl_cities', function(Blueprint $column){
            $column->increments('id');
            $column->string('country_id', 5);
            $column->longText('name');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_cities');
    }
}