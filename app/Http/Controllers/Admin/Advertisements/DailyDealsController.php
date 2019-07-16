<?php
namespace App\Http\Controllers\Admin\Advertisements;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class DailyDealsController extends Controller{
	function index(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Header Data
            $result = array(
                'page_title' => 'Manage Daily Deals',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Getting Products
            $query = DB::table('tbl_products')
                         ->select('tbl_products.id', 'tbl_products_featured_images.featured_image', 'name', 'sku_code', 'tbl_products.created_date', 'regural_price', 'sale_price', 'quantity', 'tbl_products.status', 'is_approved', 'first_name', 'last_name', 'from_date', 'to_date', 'deal_start_time', 'deal_end_time')
                         ->leftJoin('tbl_products_featured_images', 'tbl_products_featured_images.product_id', '=', 'tbl_products.id')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_products.user_id')
                         ->where('tbl_products.is_daily_deal', 0)
                         ->where('tbl_products.to_date', '>=', date('Y-m-d'))
                         ->orderBy('tbl_products.id', 'DESC');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();

            //Query For Getting Vendors
            $query = DB::table('tbl_products')
                         ->select('tbl_users.id', 'first_name', 'last_name')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_products.user_id')
                         ->orderBy('tbl_products.id', 'DESC')
                         ->groupBy('tbl_products.user_id');
            $result['vendors'] = $query->get();

            //call page
            return view('admin.advertisements.daily_deals.manage', $result); 
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function add_daily_deals(Request $request, $id){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
             $query = DB::table('tbl_products')
                         ->select('regural_price')
                         ->where('id', $id);
            $cost_price = $query->first();
            
            if($request->input('sale_price') >= $cost_price->regural_price){
                //Flash Error Msg
                $request->session()->flash('alert-danger', 'Sale price must be less than the Retail price.');
            }else{
                //Set Field data according to table columns
                $data = array(
                    'sale_price' => $request->input('sale_price'), 
                    'from_date' => date('Y-m-d', strtotime(explode(' ', $request->input('from_date'))[0])), 
                    'to_date' => date('Y-m-d', strtotime(explode(' ', $request->input('to_date'))[0])),
                    'deal_start_time' => date('H:i:s', strtotime(explode(' ', $request->input('from_date'))[1])),
                    'deal_end_time' => date('H:i:s', strtotime(explode(' ', $request->input('to_date'))[1])),
                    'is_daily_deal' => 0,
                );
                
                //Query For Updating Data
                $query = DB::table('tbl_products')
                             ->where('id', $id)
                             ->update($data);

                if(!empty($query == 1)){
                    //Flash Erro Msg
                    $request->session()->flash('alert-success', 'Sale Price has been updated successfully');
                }else{
                    //Flash Erro Msg
                    $request->session()->flash('alert-danger', 'Something went wrong !!');
                }
            }

            //Redirect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function search(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Header Data
            $result = array(
                'page_title' => 'Search Records',
                'meta_keywords' => '',
                'meta_description' => '',
            ); 

            $query = DB::table('tbl_products')
                         ->select('tbl_products.id', 'tbl_products_featured_images.featured_image', 'name', 'sku_code', 'tbl_products.created_date', 'regural_price', 'sale_price', 'quantity', 'tbl_products.status', 'is_approved', 'first_name', 'last_name', 'from_date', 'to_date', 'deal_start_time', 'deal_end_time')
                         ->leftJoin('tbl_products_featured_images', 'tbl_products_featured_images.product_id', '=', 'tbl_products.id')
                         ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_products.user_id');
                         if(!empty($request->input('name'))){
                   $query->where('name', 'LIKE', '%'.$request->input('name').'%');
                         }
                         if(!empty($request->input('sku'))){
                   $query->where('sku_code', 'LIKE', '%'.$request->input('sku').'%');
                         }
                         if(!empty($request->input('is_daily_deal') != 2 && $request->input('is_daily_deal') == 0)){
                   $query->where('is_daily_deal', $request->input('is_daily_deal'));
                         }
                         if(!empty($request->input('is_daily_deal') != 2 && $request->input('is_daily_deal') == 1)){
                   $query->where('is_daily_deal', 0)
                         ->where('tbl_products.to_date', '>=', date('Y-m-d'));
                         }
                   $query->orderBy('tbl_products.id', 'DESC');
            $result['query'] = $query->paginate(10);
            $result['total_records'] = $result['query']->count();

            //call page
            return view('admin.advertisements.daily_deals.manage', $result); 
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }
}