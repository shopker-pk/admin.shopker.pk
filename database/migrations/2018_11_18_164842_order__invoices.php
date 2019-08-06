<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderInvoices extends Migration{
    function up(){
        Schema::create('tbl_order_invoices', function (Blueprint $column){
            $column->increments('id');
            $column->LongText('order_no');
            $column->LongText('payer_id');
            $column->LongText('transaction_id');
            $column->LongText('total');
            $column->string('status'); //0 for paid & 1 for unpaid
        });
    }

    function down(){
        Schema::dropIfExist('tbl_order_invoices');
    }
}