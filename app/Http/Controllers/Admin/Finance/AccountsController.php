<?php
namespace App\Http\Controllers\Admin\Finance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class AccountsController extends Controller{
	function manage(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Manage Account Statement',
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
            $result['query'] = $query->get();

            if(count($result['query'])){
                $total_commission = 0;
                $total_earning = 0;
                $sub_total = 0;
                foreach($result['query'] as $row){
                    $total_earning += +$row->product_amount;
                    $total_commission += +round(($row->commission_percent / 100) * $row->product_amount);
                    
                }
                
                $result['query'] = array(
                    'total_commission' => $total_commission,
                    'total_earning' => $total_earning,
                    'sub_total' => $total_earning - $total_commission,
                );
            }

            //Call Page
            return view('admin.payments.finance.accounts.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

    function search(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
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
                         if(!empty($request->input('from'))){
                   $query->where(DB::raw('MONTH(tbl_orders.order_date)'), '<=', date('m', strtotime($request->input('from')))); 
                         }
                         if(!empty($request->input('to'))){
                   $query->where(DB::raw('MONTH(tbl_orders.order_date)'), '>=', date('m', strtotime($request->input('to')))); 
                         }
                   $query->orderBy('tbl_orders.id', 'DESC');
            $results = $query->get();

            if(count($results) > 0){
                $total_commission = 0;
                $total_earning = 0;
                $sub_total = 0;
                foreach($results as $row){
                    $total_earning += +$row->product_amount;
                    $total_commission += +round(($row->commission_percent / 100) * $row->product_amount);
                    
                }
                
                $result['query'] = array(
                    'total_commission' => $total_commission,
                    'total_earning' => $total_earning,
                    'sub_total' => $total_earning - $total_commission,
                );

            }else{
                $result['query'] = array(
                    'total_commission' => 0,
                    'total_earning' => 0,
                    'sub_total' => 0,
                );
            }

            //Call Page
            return view('admin.payments.finance.accounts.manage', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

    function export(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Inputs Validation
            $input_validations = $request->validate([
                'file_name' => 'required',
            ]);

            //Query For Getting Orders Overview Data
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_products.sku_code', 'tbl_orders.product_amount', 'tbl_orders.status as operational_status', 'tbl_orders_invoices.status as payout_status', 'tbl_vendors_commission.type as commission_type', 'tbl_vendors_commission.total_percent as commission_percent')
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->leftJoin('tbl_orders_invoices', 'tbl_orders_invoices.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.seller_id')
                         ->leftJoin('tbl_vendors_commission', 'tbl_vendors_commission.vendor_id', '=', 'tbl_orders.seller_id')
                         ->leftJoin('tbl_product_categories', 'tbl_product_categories.product_id', '=', 'tbl_orders.product_id');
                         if(!empty($request->input('from_date'))){
                   $query->where('tbl_orders.order_date', '>=', $request->input('from_date'));
                         }
                         if(!empty($request->input('end_date'))){
                   $query->where('tbl_orders.order_date', '<=', $request->input('end_date'));
                         }
                   $query->orderBy('tbl_orders.id', 'DESC');
            $results = $query->get();

            if(count($results) > 0){
                $total_commission = 0;
                $total_earning = 0;
                $sub_total = 0;
                $result = array();
                foreach($results as $row){
                    $total_earning += +$row->product_amount;
                    $total_commission += +round(($row->commission_percent / 100) * $row->product_amount);
                    
                }
                

                if($total_commission == 0){
                    $total_commission = '0';
                }else{
                    $total_commission = $total_commission;
                }

                $data = array(
                    'Item Charges' => $total_earning,
                    'Shopker Fees' => $total_commission,
                    'Subtotal' => $total_earning - $total_commission,
                    'Total Balance' => $total_earning - $total_commission,
                );

                $result[] = (array)$data;

                //Export As Excel File
                $excel_sheet = Excel::create($request->input('file_name'), function($excel) use ($result){
                    $excel->sheet('New sheet', function($sheet) use ($result){
                        $sheet->fromArray($result);
                    });
                })->download('xlsx');
                
                //Flash Success Message
                $request->session()->flash('alert-success', 'Account Statement has been export successfully');
            }else{
                //Flash Error Message
                $request->session()->flash('alert-danger', 'No records found for export.');
            }
            
            //Redirect 
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function pdf(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Query For Getting Orders Overview Data
            $query = DB::table('tbl_orders')
                         ->select('tbl_orders.order_no', 'tbl_orders.order_date', 'tbl_products.sku_code', 'tbl_orders.product_amount', 'tbl_orders.status as operational_status', 'tbl_orders_invoices.status as payout_status', 'tbl_vendors_commission.type as commission_type', 'tbl_vendors_commission.total_percent as commission_percent')
                         ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_orders.product_id')
                         ->leftJoin('tbl_orders_invoices', 'tbl_orders_invoices.order_no', '=', 'tbl_orders.order_no')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_orders.seller_id')
                         ->leftJoin('tbl_vendors_commission', 'tbl_vendors_commission.vendor_id', '=', 'tbl_orders.seller_id')
                         ->leftJoin('tbl_product_categories', 'tbl_product_categories.product_id', '=', 'tbl_orders.product_id');
                         if(!empty($request->input('from'))){
                   $query->where(DB::raw('MONTH(tbl_orders.order_date)'), '<=', date('m', strtotime($request->input('from')))); 
                         }
                         if(!empty($request->input('to'))){
                   $query->where(DB::raw('MONTH(tbl_orders.order_date)'), '>=', date('m', strtotime($request->input('to')))); 
                         }
                   $query->orderBy('tbl_orders.id', 'DESC');
            $results = $query->get();

            if(count($results) > 0){
                $total_commission = 0;
                $total_earning = 0;
                $sub_total = 0;
                foreach($results as $row){
                    $total_earning += +$row->product_amount;
                    $total_commission += +round(($row->commission_percent / 100) * $row->product_amount);
                    
                }
                
                $result['query'] = array(
                    'total_commission' => $total_commission,
                    'total_earning' => $total_earning,
                    'sub_total' => $total_earning - $total_commission,
                );

            }else{
                $result['query'] = array(
                    'total_commission' => 0,
                    'total_earning' => 0,
                    'sub_total' => 0,
                );
            }

            //Download PDF
            $pdf = PDF::loadView('admin.payments.finance.accounts.pdf', $result)->setPaper('A4', 'Portrait');
            return $pdf->download('Statement.pdf');
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }
}