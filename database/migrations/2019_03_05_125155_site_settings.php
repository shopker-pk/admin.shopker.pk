<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiteSettings extends Migration{
    function up(){
        Schema::create('tbl_site_settings', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('admin_id');
            $column->string('title');
            $column->string('address', 255)->nullable();
            $column->string('country_id', 5)->nullable();
            $column->string('city_id', 5)->nullable();
            $column->integer('zip_code')->nullable();
            $column->string('phone_1', 13)->unique();
            $column->string('phone_2', 13)->unique()->nullable();
            $column->string('email_1', 50)->unique();
            $column->string('email_2', 50)->unique()->nullable();
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_site_settings');
    }
}
