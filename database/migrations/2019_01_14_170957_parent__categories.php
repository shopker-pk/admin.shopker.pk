<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ParentCategories extends Migration{
    function up(){
        Schema::create('tbl_parent_categories', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('user_id');
            $column->string('featured_image')->nullable();
            $column->string('name', 100);
            $column->string('slug', 100);
            $column->integer('sorting_order')->default(0)->unique();
            $column->longText('meta_keywords')->nullable();
            $column->longText('meta_description')->nullable();
            $column->integer('status');
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_parent_categories');
    }
}
