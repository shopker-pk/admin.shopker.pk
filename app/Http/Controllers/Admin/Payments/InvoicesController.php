<?php
namespace App\Http\Controllers\Admin\Payments;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use PDF;

class InvoicesController extends Controller{
    function index(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Header Data
            $result = array(
                'page_title' => 'Manage Invoices',
                'meta_keywords' => 'manage_invoices',
                'meta_description' => 'manage_invoices',
            );

            //Query for Getting Data
            $query = DB::table('tbl_order_invoices')
                         ->select('tbl_order_invoices.payer_id', 'tbl_order_invoices.transaction_id', 'tbl_order_invoices.total', 'tbl_order_invoices.status as invoice_status', 'tbl_orders.order_no', 'tbl_orders.status as order_status', 'tbl_orders.order_date', 'tbl_users.first_name', 'tbl_users.last_name')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_order_invoices.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id')
                         ->where('tbl_orders.seller_id', $request->session()->get('id'))
                         ->orderBy('tbl_order_invoices.order_no', 'DESC')
                         ->groupBy('tbl_orders.order_no');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();

            //call page
            return view('admin.payments.invoices.manage', $result); 
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function details(Request $request, $order_no){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Header Data
            $result = array(
                'page_title' => 'Invoice Details',
                'meta_keywords' => 'invoice_details',
                'meta_description' => 'invoice_details',
            );

            //Query For Getting Data
            $query = DB::table('tbl_site_settings')
                         ->select('tbl_site_settings.title', 'tbl_site_settings.address', 'tbl_site_settings.zip_code', 'tbl_cities.name as city_name', 'tbl_countries.country_name', 'tbl_site_images.footer_image')
                         ->leftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_site_settings.city_id')
                         ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_site_settings.country_id')
                         ->leftJoin('tbl_site_images', 'tbl_site_images.admin_id', '=', 'tbl_site_settings.admin_id');
            $result['header_details'] = $query->first();

            //Query For Getting Invoice Details & Customer Details
            $query = DB::table('tbl_order_invoices')
                         ->select('tbl_order_invoices.transaction_id', 'tbl_order_invoices.total', 'tbl_order_invoices.status as payment_status', 'tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_orders.status as order_status', 'tbl_users.first_name', 'tbl_users.last_name', 'tbl_users.email', 'tbl_users.phone_no')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_order_invoices.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id')
                         ->where('tbl_orders.order_no', $order_no)
                         ->groupBy('tbl_orders.order_no');
            $result['invoice_and_customer_details'] = $query->first();
            
            //Query For Getting Order Products & Amount
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.type', 'tbl_orders.quantity as product_quantity', 'tbl_orders.product_amount as product_price', 'tbl_products.name as product_name', DB::raw('tbl_orders.quantity * tbl_orders.product_amount as total_amount'))
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->where('tbl_orders.order_no', $order_no)
                         ->orderBy('tbl_products.id', 'DESC');
            $result['order_details'] = $query->get();   

            //Query For Getting Order Payment Detail
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.type', 'tbl_orders.quantity as product_quantity', 'tbl_orders.product_amount as product_price', DB::raw('tbl_orders.quantity * tbl_orders.product_amount as total_amount'), 'tbl_products.regural_price', 'tbl_products.sale_price', DB::raw('tbl_products.regural_price - tbl_orders.product_amount as discount'))
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->where('tbl_orders.order_no', $order_no)
                         ->orderBy('tbl_orders.id', 'DESC');
            $payment_details = $query->get();

            if(!empty($payment_details)){
                $subtotal = 0;
                $discount = 0;
                $total = 0;
                foreach($payment_details as $row){
                    $subtotal += $row->total_amount;
                    $discount += $row->discount;
                    $total = $subtotal + $discount;
                }
            }
            $result['subtotal'] = $subtotal;
            $result['discount'] = $discount;
            $result['total'] = $total;
            
            //call page
            return view('admin.payments.invoices.details', $result); 
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function download(Request $request, $order_no){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            set_time_limit(300);
            //Query For Getting Data
            $query = DB::table('tbl_store_settings')
                         ->select('tbl_store_settings.store_name', 'tbl_store_settings.store_address', 'tbl_store_settings.zip_code', 'tbl_cities.name as city_name', 'tbl_countries.country_name', 'tbl_store_images.footer_image')
                         ->leftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_store_settings.city_id')
                         ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_store_settings.country_id')
                         ->leftJoin('tbl_store_images', 'tbl_store_images.user_id', '=', 'tbl_store_settings.user_id');
            $result['header_details'] = $query->first();

            //Query For Getting Invoice Details & Customer Details
            $query = DB::table('tbl_order_invoices')
                         ->select('tbl_order_invoices.transaction_id', 'tbl_order_invoices.total', 'tbl_order_invoices.status as payment_status', 'tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_orders.status as order_status', 'tbl_users.first_name', 'tbl_users.last_name', 'tbl_users.email', 'tbl_users.phone_no')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_order_invoices.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id')
                         ->where('tbl_orders.order_no', $order_no)
                         ->where('tbl_orders.seller_id', $request->session()->get('id'))
                         ->groupBy('tbl_orders.order_no');
            $result['invoice_and_customer_details'] = $query->first();
            
            //Query For Getting Order Products & Amount
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.type', 'tbl_orders.quantity as product_quantity', 'tbl_orders.product_amount as product_price', 'tbl_products.name as product_name', DB::raw('tbl_orders.quantity * tbl_orders.product_amount as total_amount'))
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->where('tbl_orders.order_no', $order_no)
                         ->orderBy('tbl_products.id', 'DESC');
            $result['order_details'] = $query->get();   

            //Query For Getting Order Payment Detail
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.type', 'tbl_orders.quantity as product_quantity', 'tbl_orders.product_amount as product_price', DB::raw('tbl_orders.quantity * tbl_orders.product_amount as total_amount'), 'tbl_products.regural_price', 'tbl_products.sale_price', DB::raw('tbl_products.regural_price - tbl_orders.product_amount as discount'))
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->where('tbl_orders.order_no', $order_no)
                         ->orderBy('tbl_orders.id', 'DESC');
            $payment_details = $query->get();

            if(!empty($payment_details)){
                $subtotal = 0;
                $discount = 0;
                $total = 0;
                foreach($payment_details as $row){
                    $subtotal += $row->total_amount;
                    $discount += $row->discount;
                    $total = $subtotal + $discount;
                }
            }
            $result['subtotal'] = $subtotal;
            $result['discount'] = $discount;
            $result['total'] = $total;
            //return view('admin.payments.invoices.pdf', $result); 
            
            //Download PDF
            $pdf = PDF::loadView('admin.payments.invoices.pdf', $result)->setPaper('a4', 'landscape');
            return $pdf->stream('order_'.$order_no.'.pdf');
            //$pdf->download('orders.pdf');
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }
}