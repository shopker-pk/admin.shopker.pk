<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChildCategories extends Migration{
    function up(){
        Schema::create('tbl_child_categories', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('user_id');
            $column->integer('parent_id');
            $column->string('featured_image')->nullable();
            $column->string('name', 100)->unique();
            $column->string('slug', 100)->nullable()->unique();
            $column->longText('meta_keywords')->nullable();
            $column->longText('meta_description')->nullable();
            $column->integer('status');
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_child_categories');
    }
}
