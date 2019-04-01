<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PagesMetaDetails extends Migration{
    function up(){
        Schema::create('tbl_pages_meta_details', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('user_id');
            $column->integer('page_id');
            $column->longText('meta_keywords');
            $column->longText('meta_description');
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_pages_meta_details');
    }
}