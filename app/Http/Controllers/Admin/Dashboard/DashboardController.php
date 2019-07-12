<?php
namespace App\Http\Controllers\Admin\Dashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class DashboardController extends Controller{
	function index(Request $request){
    	if(!empty($request->session()->has('id')) && $request->session()->get('role') == 0){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Admin Dashboard',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Counting All Products
            $query = DB::table('tbl_products')
                         ->select(DB::raw('count(id) as total_products'));
            $result['total_products'] = $query->first();

            //Query For Counting All Customers
            $query = DB::table('tbl_users')
                         ->select(DB::raw('count(id) as total_users'));
            $result['total_users'] = $query->first();

            //Query For Counting All New Orders
            $query = DB::table('tbl_orders')
                         ->select(DB::raw('count(order_no) as new_orders'))
                         ->where('order_date', date('Y-m-d'))
                         ->groupBy('order_no');
            $result['total_new_orders'] = $query->first();

            //Query For Calculating Total Earning
            $query = DB::table('tbl_orders_invoices')
                         ->select(DB::raw('SUM(total) as total_earning'));
            $result['total_earning'] = $query->first();

            //Getting Recent 3 Buyers with total order amount
            $query = DB::table('tbl_orders')
                         ->select('first_name', 'last_name', 'image', 'total')
                         ->leftJoin('tbl_orders_invoices', 'tbl_orders_invoices.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id')
                         ->orderBy('tbl_orders.order_no', 'DESC')
                         ->groupBy('tbl_orders.order_no')
                         ->limit(10);
            $result['recent_customers'] = $query->get();

            //dd($result['total_products']);
            //Call Page
            return view('admin.dashboard.dashboard', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
    }

    function monthly_sales(Request $request){
        if(!empty($request->session()->has('id')) && $request->session()->get('role') == 0){
            //initializing Generate data variables
            $ajax_response_data = array(
                'ERROR' => 'FALSE',
                'DATA' => '',
            );

            //Query For Getting Sales By Month
            $query = DB::table('tbl_orders_invoices')
                         ->select(DB::raw('SUM(total) as total_sales'), DB::raw('MONTHNAME(order_date) as months'))
                         ->groupBy(DB::raw('MONTH(order_date)'))
                         ->orderBy('order_date', 'DESC');
            $result = $query->get();

            if(!empty($result)){
                foreach($result as $row){
                    $data[] = array(
                        'month' => $row->months,
                        'sale' => $row->total_sales,
                    );
                }

                $ajax_response_data = array(
                    'ERROR' => 'FALSE',
                    'DATA' => $data,
                );
            }else{
               $ajax_response_data = array(
                    'ERROR' => 'TRUE',
                    'DATA' => '',
                ); 
            }

            echo json_encode($ajax_response_data);
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }
}