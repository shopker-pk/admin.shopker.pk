<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Countries extends Migration{
    function up(){
        Schema::create('tbl_countries', function (Blueprint $column){
            $column->increments('id');
            $column->longText('country_name');
            $column->string('country_code', 5);
        });
    }

    function down(){
        Schema::dropIfExist('tbl_countries');
    }
}