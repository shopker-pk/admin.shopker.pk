<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SiteShippingSettings extends Migration{
    function up(){
        Schema::create('tbl_site_shipping_settings', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('admin_id');
            $column->integer('shipping_mood')->nullable();
            $column->integer('international_shipping_mood')->nullable();
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_site_shipping_settings');
    }
}
