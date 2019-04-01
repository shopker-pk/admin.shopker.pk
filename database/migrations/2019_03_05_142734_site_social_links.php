<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiteSocialLinks extends Migration{
    function up(){
        Schema::create('tbl_site_social_links', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('admin_id');
            $column->string('facebook', 100)->nullable();
            $column->string('twitter', 100)->nullable();
            $column->string('googleplus', 100)->nullable();
        });
    }

    function down(){
        Schema::dropIfExist('tbl_site_social_links');
    }
}