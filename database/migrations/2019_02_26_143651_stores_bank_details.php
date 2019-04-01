<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StoresBankDetails extends Migration{
    function up(){
        Schema::create('tbl_stores_bank_details', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('store_id');
            $column->string('name', 20)->unique();
            $column->string('title', 20)->unique();
            $column->string('account_no', 20)->unique();
            $column->string('branch_code', 20)->unique();
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_stores_bank_details');
    }
}
