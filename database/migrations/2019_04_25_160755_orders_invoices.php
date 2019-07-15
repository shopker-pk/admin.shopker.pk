<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersInvoices extends Migration{
    function up(){
        Schema::create('tbl_orders_invoices', function (Blueprint $column){
            $column->increments('id');
            $column->LongText('order_no');
            $column->LongText('payer_id');
            $column->LongText('transaction_id');
            $column->LongText('total');
            $column->string('status'); //0 for paid & 1 for unpaid
            $column->date('order_date');
            $column->Time('order_time');
        });
    }

    function down(){
        Schema::create('tbl_orders_invoices');
    }
}
