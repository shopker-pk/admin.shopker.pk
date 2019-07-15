<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiteImages extends Migration{
    function up(){
        Schema::create('tbl_site_images', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('admin_id');
            $column->string('header_image', 20)->nullable();
            $column->string('footer_image', 20)->nullable();
            $column->string('favicon_image', 20)->nullable();
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::table('tbl_site_images');
    }
}
