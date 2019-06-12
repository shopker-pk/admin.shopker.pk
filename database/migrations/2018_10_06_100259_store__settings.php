<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StoreSettings extends Migration{
    function up(){
        Schema::create('tbl_store_settings', function (Blueprint $column){
            $column->increments('id');
            $column->ipAddress('ip_address');
            $column->integer('vendor_id');
            $column->LongText('bussiness_name');
            $column->LongText('store_name');
            $column->LongText('store_slug');
            $column->string('store_email', 75)->unique();
            $column->string('store_phone_no', 13)->unique();
            $column->string('store_cell_no', 15)->nullable()->unique();
            $column->LongText('store_address');
            $column->LongText('warehouse_address');
            $column->string('cnic', 13)->unique();
            $column->string('ntn_no', 9)->nullable()->unique();
            $column->string('country_id', 6);
            $column->string('city_id', 10);
            $column->date('created_date');
            $column->Time('created_time');
        });
    }

    function down(){
        Schema::dropIfExist('tbl_store_settings');
    }
}
