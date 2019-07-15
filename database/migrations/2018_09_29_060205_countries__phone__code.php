<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CountriesPhoneCode extends Migration{
    function up(){
        Schema::create('tbl_countries_phone_code', function (Blueprint $column){
            $column->increments('id');
            $column->string('code');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_countries_phone_code');
    }
}