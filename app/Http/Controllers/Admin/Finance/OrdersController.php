<?php
namespace App\Http\Controllers\Admin\Finance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class OrdersController extends Controller{
	function manage(Request $request){
		//Necessary Page Data For header Page
        $result = array(
            'page_title' => 'Manage Orders Overview',
            'meta_keywords' => '',
            'meta_description' => '',
        );

        //Query For Getting Orders Overview Data
        $query = DB::table('tbl_orders')
                     ->select('tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_products.sku_code', 'tbl_orders.product_amount', 'tbl_orders.status as operational_status', 'tbl_orders_invoices.status as payout_status', 'tbl_vendors_commission.type as commission_type', 'tbl_vendors_commission.total_percent as commission_percent')
                     ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                     ->leftJoin('tbl_orders_invoices', 'tbl_orders_invoices.order_no', '=', 'tbl_orders.order_no')
                     ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.seller_id')
                     ->leftJoin('tbl_vendors_commission', 'tbl_vendors_commission.vendor_id', '=', 'tbl_orders.seller_id')
                     ->leftJoin('tbl_product_categories', 'tbl_product_categories.product_id', '=', 'tbl_orders.product_id')
                     ->orderBy('tbl_orders.id', 'DESC');
        $result['query'] = $query->paginate(10);
        $result['total_records'] = $result['query']->count();
        
        //Call Page
        return view('admin.payments.finance.orders.manage', $result);
	}

	function search(Request $request){
		//Necessary Page Data For header Page
        $result = array(
            'page_title' => 'Search Result',
            'meta_keywords' => '',
            'meta_description' => '',
        );

        //Query For Getting Orders Overview Data
        $query = DB::table('tbl_orders')
                     ->select('tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_products.sku_code', 'tbl_orders.product_amount', 'tbl_orders.status as operational_status', 'tbl_orders_invoices.status as payout_status', 'tbl_vendors_commission.type as commission_type', 'tbl_vendors_commission.total_percent as commission_percent')
                     ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                     ->leftJoin('tbl_orders_invoices', 'tbl_orders_invoices.order_no', '=', 'tbl_orders.order_no')
                     ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.seller_id')
                     ->leftJoin('tbl_vendors_commission', 'tbl_vendors_commission.vendor_id', '=', 'tbl_orders.seller_id')
                     ->leftJoin('tbl_product_categories', 'tbl_product_categories.product_id', '=', 'tbl_orders.product_id');
                     if(!empty($request->input('order_no'))){
               $query->where('tbl_orders.order_no', 'LIKE', '%'.$request->input('order_no').'%'); 
                     }
                     if(!empty($request->input('sku'))){
               $query->where('tbl_products.sku_code', 'LIKE', '%'.$request->input('sku').'%'); 
                     }
                     if(!empty($request->input('from'))){
               $query->where('tbl_orders.order_date', '<=', date('Y-m-d', strtotime($request->input('from')))); 
                     }
                     if(!empty($request->input('from'))){
               $query->where('tbl_orders.order_date', '>=', date('Y-m-d', strtotime($request->input('from')))); 
                     }
               $query->orderBy('tbl_orders.id', 'DESC');
        $result['query'] = $query->paginate(10);
        $result['total_records'] = $result['query']->count();

        //Call Page
        return view('admin.payments.finance.orders.manage', $result);
	}

    function export(Request $request){
        //Inputs Validation
        $input_validations = $request->validate([
            'file_name' => 'required',
        ]);

        $query = DB::table('tbl_orders')
                     ->select('tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_products.sku_code', 'tbl_orders.product_amount', 'tbl_orders.status as operational_status', 'tbl_orders_invoices.status as payout_status', 'tbl_vendors_commission.type as commission_type', 'tbl_vendors_commission.total_percent as commission_percent')
                     ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                     ->leftJoin('tbl_orders_invoices', 'tbl_orders_invoices.order_no', '=', 'tbl_orders.order_no')
                     ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.seller_id')
                     ->leftJoin('tbl_vendors_commission', 'tbl_vendors_commission.vendor_id', '=', 'tbl_orders.seller_id')
                     ->leftJoin('tbl_product_categories', 'tbl_product_categories.product_id', '=', 'tbl_orders.product_id');
                     if(!empty($request->input('order_no'))){
               $query->where('tbl_orders.order_no', 'like', '%'.$request->input('order_no').'%'); 
                     }
                     if(!empty($request->input('from_date'))){
               $query->where('tbl_orders.order_date', '>=', $request->input('from_date')); 
                     }
                     if(!empty($request->input('end_date'))){
               $query->where('tbl_orders.order_date', '<=', $request->input('end_date')); 
                     }
               $query->orderBy('tbl_orders.id', 'DESC');
        $results = $query->get();

        if(count($results) > 0){
            $result = array();
            foreach($results as $row){
                if($row->operational_status == 0){
                    $operational_status = 'Pending';
                }elseif($row->operational_status == 1){
                    $operational_status = 'Pending';
                }elseif($row->operational_status == 2){
                    $operational_status = 'Pending';
                }elseif($row->operational_status == 3){
                    $operational_status = 'Pending';
                }elseif($row->operational_status == 4){
                    $operational_status = 'Pending';
                }elseif($row->operational_status == 5){
                    $operational_status = 'Pending';
                }

                if($row->payout_status == 0){
                    $payout_status = 'Paid';
                }elseif($row->payout_status == 1){
                    $payout_status = 'Unpaid';
                }
                
                if(explode('%', $row->commission_percent)[0] != ''){
                    $commission = floor((explode('%', $row->commission_percent)[0] / 100) * $row->product_amount);
                }else{ 
                    $commission = floor(($row->commission_percent / 100) * $row->product_amount);
                }

                if(explode('%', $row->commission_percent)[0] != ''){ 
                    $payout_amount = floor(($row->product_amount) - (explode('%', $row->commission_percent)[0] / 100) * $row->product_amount);
                }else{ 
                    $payout_amount = floor(($row->product_amount) - ($row->commission_percent / 100) * $row->product_amount);
                }

                $data = array(
                    'Order No#' => $row->order_no,
                    'Order Date' => date('D-M-Y', strtotime($row->order_date)),
                    'Product SKU' => $row->sku_code,
                    'Sale Price' => $row->product_amount,
                    'Commision' => $commission,
                    'Payout Amount' => $payout_amount,
                    'Operational Status' => $operational_status,
                    'Payout Status' => $payout_status,
                );

                $result[] = (array)$data;
            }
            

            //Export As Excel File
            $excel_sheet = Excel::create($request->input('file_name'), function($excel) use ($result){
                $excel->sheet('New sheet', function($sheet) use ($result){
                    $sheet->fromArray($result);
                });
            })->download('xlsx');
            
            //Flash Success Message
            $request->session()->flash('alert-success', 'Orders Overview has been export successfully');
        }else{
            //Flash Error Message
            $request->session()->flash('alert-danger', 'No records found for export.');
        }
        
        //Redirect 
        return redirect()->back();
    }
}