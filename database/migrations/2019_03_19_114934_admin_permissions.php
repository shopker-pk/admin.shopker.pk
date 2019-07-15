<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdminPermissions extends Migration{
    function up(){
        Schema::create('tbl_admin_permissions', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('added_by');
            $column->integer('admin_id');
            $column->integer('permission_id');
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_admin_permissions');
    }
}