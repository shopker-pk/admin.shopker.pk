<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VendorsCommission extends Migration{
    function up(){
        Schema::create('tbl_vendors_commission', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('admin_id');
            $column->integer('vendor_id');
            $column->integer('type'); // 0 for total commission & 1 for category wise commission
            $column->integer('category_id'); // 0 for all categories
            $column->string('total_percent', 10); // in percent
            $column->date('created_date');
            $column->time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_vendors_commission');
    }
}