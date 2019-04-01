<?php
namespace App\Http\Controllers\Admin\Orders;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class OrdersController extends Controller{
	function view_orders(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Manage Orders',
                'meta_keywords' => 'manage_orders',
                'meta_description' => 'manage_orders',
            );
            
            //Query For Getting Orders
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.id as o_id', 'tbl_orders.order_no', 'tbl_orders.payment_method', 'tbl_orders.order_date', 'tbl_orders.status as o_status', 'tbl_order_invoices.status as p_status', 'tbl_users.first_name', 'tbl_users.last_name')
                         ->leftJoin('tbl_order_invoices', 'tbl_order_invoices.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id')
                         ->groupBy('tbl_orders.order_no')
                         ->orderBy('tbl_orders.id', 'DESC');
         	$result['query'] = $query->paginate(10); 
         	$result['total_records'] = $result['query']->count(); 

         	//Call Page
            return view('admin.orders.manage', $result);
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
	}

	function details(Request $request, $order_no){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $order_no)){
			//Necessary Page Data For header Page
            $result = array(
                'page_title' => 'View Order Details',
                'meta_keywords' => 'view_order_details',
                'meta_description' => 'view_order_details',
            );

            //Query For Getting Order Products
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.product_id', 'tbl_orders.quantity', 'tbl_orders.type', 'tbl_products_featured_images.featured_image', 'tbl_products.name', 'tbl_products.regural_price', 'tbl_orders.product_amount', 'tbl_products.sku_code')
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->leftJoin('tbl_products_featured_images', 'tbl_products_featured_images.product_id', '=', 'tbl_orders.product_id')
                         ->where('tbl_orders.order_no', $order_no);
            $result['cart_details'] = $query->get();

            //Query For Getting Customer Details
            $query = DB::table('tbl_orders')
                         ->select('tbl_users.first_name', 'tbl_users.last_name', 'tbl_users.phone_no', 'tbl_users.email', 'tbl_users.address')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id')
                         ->where('tbl_orders.order_no', $order_no);
         	$result['customer_details'] = $query->first();

        	//Query For Getting Shipping Details
        	$query = DB::table('tbl_orders')
                         ->select('tbl_orders_shipping_details.name', 'tbl_orders_shipping_details.contact_no', 'tbl_orders_shipping_details.city_id', 'tbl_orders_shipping_details.country_id', 'tbl_orders_shipping_details.address', 'tbl_cities.name as city_name', 'tbl_countries.country_name')
                         ->leftJoin('tbl_orders_shipping_details', 'tbl_orders_shipping_details.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_orders_shipping_details.city_id')
                         ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_orders_shipping_details.country_id')
                         ->where('tbl_orders.order_no', $order_no);
         	$result['shipping_details'] = $query->first();

         	//Query For Getting Order Summary
         	$query = DB::table('tbl_orders')
                         ->select('tbl_orders.order_no', 'tbl_order_delivery_charges.charges', 'tbl_order_invoices.total', DB::raw('SUM(tbl_order_invoices.total - tbl_order_delivery_charges.charges) as sub_total'))
                         ->leftJoin('tbl_order_delivery_charges', 'tbl_order_delivery_charges.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_order_invoices', 'tbl_order_invoices.order_no', '=', 'tbl_orders.order_no')
                         ->where('tbl_orders.order_no', $order_no);
         	$result['order_summary'] = $query->first();

            //Call Page
            return view('admin.orders.details', $result);
		}else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

	function update_payment_status(Request $request, $order_no){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $order_no)){
			//Set Field data according to table column
            $data = array(
                'tbl_order_invoices.status' => $request->input('payment_status'),
            );

			//Query For Updating Data
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.order_no', 'tbl_order_invoices.order_no', 'tbl_order_invoices.status')
                         ->leftJoin('tbl_order_invoices', 'tbl_order_invoices.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id')
                         ->where('tbl_orders.seller_id', $request->session()->get('id'))
                         ->where('tbl_orders.order_no', $order_no)
                         ->update($data);

            if(!empty($query)){
                //Flash Success Msg
                $request->session()->flash('alert-success', 'Payment status has been updated successfully');
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', "Something wen't wrong");
            }

            //Redirect
            return redirect()->route('manage_seller_orders');
		}
	}

	function update_order_status(Request $request, $order_no){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $order_no)){

			//Set Field data according to table column
            $data = array(
                'status' => $request->input('order_status'),
            );

			//Query For Updating Data
            $query = DB::table('tbl_orders')
                         ->where('order_no', '=', $order_no)
                         ->where('seller_id', '=', $request->session()->get('id'))
                         ->update($data);

            if(!empty($query)){
                //Flash Success Msg
                $request->session()->flash('alert-success', 'Order status has been updated successfully');
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', "Something wen't wrong");
            }

            //Redirect
            return redirect()->route('manage_seller_orders');
		}
	}

    function export(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.order_no', 'tbl_orders.quantity', 'tbl_orders.product_amount', 'tbl_orders.type', 'tbl_orders.payment_method', 'tbl_orders.status', 'tbl_orders.order_date', 'tbl_orders.order_time', 'tbl_users.first_name', 'tbl_users.last_name', 'tbl_users.cell_number1', 'tbl_users.email', 'tbl_users.address', 'tbl_countries_phone_code.code',  'tbl_products.name', 'tbl_products.regural_price', 'tbl_orders.product_amount', 'tbl_products.sku_code')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id')
                         ->leftJoin('tbl_countries_phone_code', 'tbl_countries_phone_code.id', '=', 'tbl_users.country_code_1')
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->where('tbl_orders.status', $request->input('order_type'));
            $results = $query->get();
            if(!empty($results)){
                $result = array();
                foreach($results as $row){
                    if($row->type == 0){
                        $type = 'Normal';
                    }else{
                        $type = 'On Sale';
                    }

                    if($row->payment_method == 0){
                        $payment_method = 'Paypal';
                    }elseif($row->payment_method == 1){
                        $payment_method = 'Stripe';
                    }elseif($row->payment_method == 2){
                        $payment_method = 'Bank Transaction';
                    }else{
                        $payment_method = 'Cash on delivery';
                    }

                    $data = array(
                        'Order No#' => $row->order_no,
                        'Payment Method' => $payment_method,
                        'Order Date' => date('D-M-Y', strtotime($row->order_date)),
                        'Order Time' => date('h:i:s a', strtotime($row->order_time)),
                        'Customr Name' => $row->first_name.' '.$row->last_name,
                        'Customr Contact No#' => $row->code.''.$row->cell_number1,
                        'Customr Email' => $row->email,
                        'Customr Address' => $row->address,
                        'Product Name' => $row->name,
                        'Product Retail Price' => $row->regural_price,
                        'Product SKU Code' => $row->sku_code,
                        'Product Quantity' => $row->quantity,
                        'Product Sale Price' => $row->product_amount,
                        'Product Type' => $type,
                    );

                    $result[] = (array)$data;
                }
                

                //Export As Excel File
                $excel_sheet = Excel::create($request->input('name'), function($excel) use ($result){
                    $excel->sheet('New sheet', function($sheet) use ($result){
                        $sheet->fromArray($result);
                    });
                })->download('xlsx');
                
                //Flash Success Message
                $request->session()->flash('alert-success', 'Variations has been export successfully');
            }else{
                //Flash Error Message
                $request->session()->flash('alert-danger', 'No records found for export.');
            }
            
            //Redirect 
            return redirect()->route('manage_variations');
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

            //Query For Getting Orders
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.id as o_id', 'tbl_orders.order_no', 'tbl_orders.payment_method', 'tbl_orders.order_date', 'tbl_orders.status as o_status', 'tbl_order_invoices.status as p_status', 'tbl_users.first_name', 'tbl_users.last_name')
                         ->leftJoin('tbl_order_invoices', 'tbl_order_invoices.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.buyer_id');
                         if(!empty($request->input('order_no'))){
                   $query->where('tbl_orders.order_no', $request->input('order_no'));
                         }
                         if(!empty($request->input('payment_type'))){
                   $query->where('tbl_orders.payment_type', $request->input('payment_type'));
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
                   $query->groupBy('tbl_orders.order_no')
                         ->orderBy('tbl_orders.id', 'DESC');
         	$result['query'] = $query->paginate(10); 
         	$result['total_records'] = $result['query']->count();
            
         	//Call Page
            return view('admin.orders.manage', $result);
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
	}
}