<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BannerAdvertisements extends Migration{
    function up(){
        Schema::create('tbl_banner_advertisements', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('user_id');
            $column->string('image', 25);
            $column->longText('url')->nullable();
            $column->integer('page_id');
            $column->integer('type');
            $column->date('start_date');
            $column->date('end_date');
            $column->integer('status');
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_banner_advertisements');
    }
}
