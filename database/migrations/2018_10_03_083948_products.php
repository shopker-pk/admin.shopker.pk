<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Products extends Migration{
    function up(){
        Schema::create('tbl_products', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('user_id');
            $column->integer('admin_id')->nullable();
            $column->string('name');
            $column->string('slug');
            $column->longText('high_light');
            $column->longText('description');
            $column->integer('warranty_type');
            $column->string('what_in_the_box');
            $column->string('weight', 10);
            $column->integer('length')->nullable();
            $column->integer('width')->nullable();
            $column->integer('height')->nullable();
            $column->integer('variation_id');
            $column->string('sku_code');
            $column->string('regural_price', 5);
            $column->string('sale_price', 5)->nullable();
            $column->integer('quantity');
            $column->date('from_date')->nullable();
            $column->date('to_date')->nullable();
            $column->integer('status')->default(1);
            $column->integer('is_approved');
            $column->integer('is_daily_deal')->default(1);
            $column->Time('deal_start_time')->nullable();
            $column->Time('deal_end_time')->nullable();
            $column->LongText('video_url')->nullable();
            $column->longText('meta_keywords')->nullable();
            $column->longText('meta_description')->nullable();
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_products');
    }
}
