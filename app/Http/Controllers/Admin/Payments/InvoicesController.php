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
            $query = DB::table('tbl_orders_invoices')
                         ->select('tbl_orders_invoices.payer_id', 'tbl_orders_invoices.transaction_id', 'tbl_orders_invoices.total', 'tbl_orders_invoices.status as invoice_status', 'tbl_orders.order_no', 'tbl_orders.status as order_status', 'tbl_orders.order_date', 'tbl_users.first_name', 'tbl_users.last_name')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_orders_invoices.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id')
                         ->orderBy('tbl_orders_invoices.order_no', 'DESC')
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
            $query = DB::table('tbl_orders_invoices')
                         ->select('tbl_orders_invoices.transaction_id', 'tbl_orders_invoices.total', 'tbl_orders_invoices.status as payment_status', 'tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_orders.status as order_status', 'tbl_users.first_name', 'tbl_users.last_name', 'tbl_users.email', 'tbl_users.phone_no')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_orders_invoices.order_no')
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
                         ->select('tbl_shipping_charges.charges', 'tbl_orders_invoices.total', DB::raw('SUM(tbl_orders_invoices.total - tbl_shipping_charges.charges) as sub_total'))
                         ->leftJoin('tbl_shipping_charges', 'tbl_shipping_charges.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_orders_invoices', 'tbl_orders_invoices.order_no', '=', 'tbl_orders.order_no')
                         ->where('tbl_orders.order_no', $order_no);
            $result['payment_details'] = $query->first();
            
            //call page
            return view('admin.payments.invoices.details', $result); 
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function print_details(Request $request, $order_no){
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
            $query = DB::table('tbl_orders_invoices')
                         ->select('tbl_orders_invoices.transaction_id', 'tbl_orders_invoices.total', 'tbl_orders_invoices.status as payment_status', 'tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_orders.status as order_status', 'tbl_users.first_name', 'tbl_users.last_name', 'tbl_users.email', 'tbl_users.phone_no')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_orders_invoices.order_no')
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
                         ->select('tbl_shipping_charges.charges', 'tbl_orders_invoices.total', DB::raw('SUM(tbl_orders_invoices.total - tbl_shipping_charges.charges) as sub_total'))
                         ->leftJoin('tbl_shipping_charges', 'tbl_shipping_charges.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_orders_invoices', 'tbl_orders_invoices.order_no', '=', 'tbl_orders.order_no')
                         ->where('tbl_orders.order_no', $order_no);
            $result['payment_details'] = $query->first();
            
            //call page
            return view('admin.payments.invoices.print', $result); 
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function download_pdf(Request $request, $order_no){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            set_time_limit(0);

            //Query For Getting Data
            $query = DB::table('tbl_site_settings')
                         ->select('tbl_site_settings.title', 'tbl_site_settings.address', 'tbl_site_settings.zip_code', 'tbl_cities.name as city_name', 'tbl_countries.country_name', 'tbl_site_images.footer_image')
                         ->leftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_site_settings.city_id')
                         ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_site_settings.country_id')
                         ->leftJoin('tbl_site_images', 'tbl_site_images.admin_id', '=', 'tbl_site_settings.admin_id');
            $result['header_details'] = $query->first();

            //Query For Getting Invoice Details & Customer Details
            $query = DB::table('tbl_orders_invoices')
                         ->select('tbl_orders_invoices.transaction_id', 'tbl_orders_invoices.total', 'tbl_orders_invoices.status as payment_status', 'tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_orders.status as order_status', 'tbl_users.first_name', 'tbl_users.last_name', 'tbl_users.email', 'tbl_users.phone_no')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_orders_invoices.order_no')
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
                         ->select('tbl_shipping_charges.charges', 'tbl_orders_invoices.total', DB::raw('SUM(tbl_orders_invoices.total - tbl_shipping_charges.charges) as sub_total'))
                         ->leftJoin('tbl_shipping_charges', 'tbl_shipping_charges.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_orders_invoices', 'tbl_orders_invoices.order_no', '=', 'tbl_orders.order_no')
                         ->where('tbl_orders.order_no', $order_no);
            $result['payment_details'] = $query->first();
            
            //Download PDF
            $pdf = PDF::loadView('admin.payments.invoices.pdf', $result)->setPaper('A4', 'landscape');
            return $pdf->download('Invoice-'.$order_no.'.pdf');

            $request->session()->flash('alert-success', 'Invoice-'.$order_no.' has been download successfully');

            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function search(Request $request){
        if(!empty($request->session()->has('id')) && $request->session()->get('role') == 0){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Search Result',
                'meta_keywords' => 'search_result',
                'meta_description' => 'search_result',
            );

            //Query for Getting Data
            $query = DB::table('tbl_orders_invoices')
                         ->select('tbl_orders_invoices.payer_id', 'tbl_orders_invoices.transaction_id', 'tbl_orders_invoices.total', 'tbl_orders_invoices.status as invoice_status', 'tbl_orders.order_no', 'tbl_orders.status as order_status', 'tbl_orders.order_date', 'tbl_users.first_name', 'tbl_users.last_name')
                         ->leftJoin('tbl_orders', 'tbl_orders.order_no', '=', 'tbl_orders_invoices.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id');
                         if(!empty($request->input('order_no'))){
                   $query->where('tbl_orders.order_no', $request->input('order_no'));
                         }
                         if(!empty($request->input('payment_type'))){
                   $query->where('tbl_orders_invoices.status', $request->input('payment_type'));
                         }
                         if(!empty($request->input('status'))){
                   $query->where('tbl_orders.status', $request->input('status'));
                         }
                         if(!empty($request->input('from_date'))){
                   $query->where('tbl_orders.order_date', '=', date('Y-m-d', strtotime($request->input('from_date'))));
                         }
                         if(!empty($request->input('to_date'))){
                   $query->where('tbl_orders.order_date', '<=', date('Y-m-d', strtotime($request->input('to_date'))));
                         }
                   $query->orderBy('tbl_orders_invoices.order_no', 'DESC')
                         ->groupBy('tbl_orders.order_no');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();

            //call page
            return view('admin.payments.invoices.manage', $result); 
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }
}