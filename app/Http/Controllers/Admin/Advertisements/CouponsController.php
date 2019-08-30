<?php
namespace App\Http\Controllers\Admin\Advertisements;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class CouponsController extends Controller{
	function index(Request $request){
		//Header Data
		$result = array(
	        'page_title' => 'Manage Coupons',
	        'meta_keywords' => '',
	        'meta_description' => '',
	    );

		//Query For Getting Coupons
	    $query = DB::table('tbl_coupons')
	    			 ->select('tbl_coupons.id', 'admin_id', 'code', 'discount_type', 'start_date', 'end_date', 'discount_offer', 'no_of_uses', 'min_order_amount', 'max_order_amount', 'limit_per_customer', 'order_type', 'tbl_coupons.status', 'tbl_coupons.created_date', 'first_name', 'last_name')
	    			 ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_coupons.vendor_id')
	    			 ->orderBy('tbl_coupons.id', 'DESC');
	 	$result['query'] = $query->paginate(10);
			$result['total_records'] = $result['query']->count();
			
			//Query For Getting All Admins
			$query = DB::table('tbl_users')
			             ->select('id', DB::raw("CONCAT(first_name, last_name) as admin_name"))
			             ->where('status', 0);
	 	$result['admins'] = $query->get();

		//call page
	    return view('admin.advertisements.coupons.manage', $result); 
	}

	function add(Request $request){
		//Header Data
    	$result = array(
            'page_title' => 'Add Coupon',
            'meta_keywords' => '',
            'meta_description' => '',
        );

    	//call page
        return view('admin.advertisements.coupons.add', $result); 
	}

	function insert(Request $request){
		//Inputs Validation
        $input_validations = $request->validate([
            'code' => 'required',
            'discount_type' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'discount_offer' => 'required',
            'no_of_uses' => 'required|numeric',
            'min_order_amount' => 'required',
            'max_order_amount' => 'required',
            'limit_per_customer' => 'required|numeric',
            'order_type' => 'required|numeric',
            'products.*' => 'required|numeric',
            'status' => 'required',
        ]);

        if(!empty($request->input('order_type') == 0)){
        	//Set Field data according to table column
	        $data = array(
	        	'admin_id' => $request->session()->get('id'),
	        	'vendor_id' => 0,
	        	'ip_address' => $request->ip(),
	            'code' => $request->input('code'),
	            'discount_type' => $request->input('discount_type'),
	            'start_date' => date('Y-m-d', strtotime($request->input('start_date'))),
	            'end_date' => date('Y-m-d', strtotime($request->input('end_date'))),
	            'discount_offer' => $request->input('discount_offer'),
	            'no_of_uses' => $request->input('no_of_uses'),
	            'min_order_amount' => $request->input('min_order_amount'),
	            'max_order_amount' => $request->input('max_order_amount'),
	            'limit_per_customer' => $request->input('limit_per_customer'),
	            'order_type' => $request->input('order_type'),
	            'status' => $request->input('status'),
	            'created_date' => date('Y-m-d'),
	            'created_time' => date('H:i:s'),
	        );

	        //Query For Inserting Data
	    	$coupon_id = DB::table('tbl_coupons')
	    	             ->insertGetId($data);	

         	foreach($request->input('products') as $row){
         		//Set Field data according to table column
	        	$data = array(
	        		'admin_id' => $request->session()->get('id'),
		        	'vendor_id' => 0,
		        	'coupon_id' => $coupon_id,
		        	'product_id' => $row,
		        	'ip_address' => $request->ip(),
		        	'created_date' => date('Y-m-d'),
	            	'created_time' => date('H:i:s'),
        		);

        		//Query For Inserting Data
		    	$query = DB::table('tbl_coupons_products')
		    	             ->insertGetId($data);
         	}

         	if(!empty($coupon_id && $query)){
                //Flash Erro Msg
                $request->session()->flash('alert-success', 'Coupon has been added successfully');

                //Redirect
        		return redirect()->back();
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Something went wrong !!');

                //Query For Deleting last Insert Coupon
                $query = DB::table('tbl_coupons')
                             ->where('id', $coupon_id)
                             ->delete();

                //Redirect
        		return redirect()->back()->withInput($request->all());
            }
        }else{
        	//Set Field data according to table column
	        $data = array(
	        	'admin_id' => $request->session()->get('id'),
	        	'vendor_id' => 0,
	        	'ip_address' => $request->ip(),
	            'code' => $request->input('code'),
	            'discount_type' => $request->input('discount_type'),
	            'start_date' => date('Y-m-d', strtotime($request->input('start_date'))),
	            'end_date' => date('Y-m-d', strtotime($request->input('end_date'))),
	            'discount_offer' => $request->input('discount_offer'),
	            'no_of_uses' => $request->input('no_of_uses'),
	            'min_order_amount' => $request->input('min_order_amount'),
	            'max_order_amount' => $request->input('max_order_amount'),
	            'limit_per_customer' => $request->input('limit_per_customer'),
	            'order_type' => $request->input('order_type'),
	            'status' => $request->input('status'),
	            'created_date' => date('Y-m-d'),
	            'created_time' => date('H:i:s'),
	        );

	        //Query For Inserting Data
	    	$query = DB::table('tbl_coupons')
	    	             ->insertGetId($data);

     		if(!empty($query)){
                //Flash Erro Msg
                $request->session()->flash('alert-success', 'Coupon has been added successfully');

                //Redirect
        		return redirect()->back();
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Something went wrong !!');

                //Query For Deleting last Insert Coupon
                $query = DB::table('tbl_coupons')
                             ->where('id', $query)
                             ->delete();

                //Redirect
        		return redirect()->back()->withInput($request->all());
            }
        }
	}

	function ajax_update_status(Request $request, $id, $status){
    	if($status == 0){
            $status = 1;
        }elseif($status == 1){
            $status = 0;
        }

        $query = DB::table('tbl_coupons')
                     ->where('id', $id)
                     ->update(array('status' => $status));

        if(!empty($query == 1)){
            //Flash Erro Msg
            $request->session()->flash('alert-success', 'Status has been updated successfully');
        }else{
            //Flash Erro Msg
            $request->session()->flash('alert-danger', 'Something went wrong !!');
        }

        //Redirect
        return redirect()->back();
	}

	function edit(Request $request, $id){
		//Header Data
    	$result = array(
            'page_title' => 'Edit Coupon',
            'meta_keywords' => '',
            'meta_description' => '',
        );

		//Query For Getting Coupon
		$query = DB::table('tbl_coupons')
		             ->select('*')
		             ->where('id', $id);
     	$coupon = $query->first();

     	if(!empty($coupon)){
     		$coupon_array = array(
 				'coupon_id' => $coupon->id,
 				'code' => $coupon->code,
 				'discount_type' => $coupon->discount_type,
 				'start_date' => date('d/m/Y', strtotime($coupon->start_date)),
 				'end_date' => date('d/m/Y', strtotime($coupon->end_date)),
 				'discount_offer' => $coupon->discount_offer,
 				'no_of_uses' => $coupon->no_of_uses,
 				'min_order_amount' => $coupon->min_order_amount,
 				'max_order_amount' => $coupon->max_order_amount,
 				'limit_per_customer' => $coupon->limit_per_customer,
 				'order_type' => $coupon->order_type,
 				'status' => $coupon->status,
 			);
 			
 			//Query for Getting Coupons Products
				$query = DB::table('tbl_coupons_products')
				             ->select('tbl_products.id', 'tbl_products.name')
				             ->leftJoin('tbl_products', 'tbl_products.id', '=', 'tbl_coupons_products.product_id')
				             ->where('tbl_coupons_products.coupon_id', $coupon_array['coupon_id'])
				             ->where('tbl_products.status', 0)
				             ->orderBy('tbl_coupons_products.id', 'DESC');
         	$products = $query->get();

         	if(count($products) > 0){
         		foreach($products as $row){
             		$products_array[] = array(
             			'product_id' => $row->id,
             			'name' => $row->name,
             		);
             	}

             	//Query For Getting All Products
             	$query = DB::table('tbl_products')
             	             ->select('id', 'name')
             	             ->where('status', 0);
             	$result['products'] = $query->get();

             	$result['coupon_products'] = $products_array;
         	}
         	
         	$result['query'] = $coupon_array; 

 			return view('admin.advertisements.coupons.edit', $result);
     	}else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
	}

	function update(Request $request, $id){
		//Inputs Validation
        $input_validations = $request->validate([
            'code' => 'required',
            'discount_type' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
            'discount_offer' => 'required',
            'no_of_uses' => 'required|numeric',
            'min_order_amount' => 'required',
            'max_order_amount' => 'required',
            'limit_per_customer' => 'required|numeric',
            'order_type' => 'required|numeric',
            'products.*' => 'required|numeric',
            'status' => 'required',
        ]);

        if(!empty($request->input('order_type') == 0)){
        	//Set Field data according to table column
	        $data = array(
	        	'admin_id' => $request->session()->get('id'),
	        	'vendor_id' => 0,
	        	'ip_address' => $request->ip(),
	            'code' => $request->input('code'),
	            'discount_type' => $request->input('discount_type'),
	            'start_date' => date('Y-m-d', strtotime($request->input('start_date'))),
	            'end_date' => date('Y-m-d', strtotime($request->input('end_date'))),
	            'discount_offer' => $request->input('discount_offer'),
	            'no_of_uses' => $request->input('no_of_uses'),
	            'min_order_amount' => $request->input('min_order_amount'),
	            'max_order_amount' => $request->input('max_order_amount'),
	            'limit_per_customer' => $request->input('limit_per_customer'),
	            'order_type' => $request->input('order_type'),
	            'status' => $request->input('status'),
	            'created_date' => date('Y-m-d'),
	            'created_time' => date('H:i:s'),
	        );

	        //Query For Inserting Data
	    	$coupon_id = DB::table('tbl_coupons')
	    	             ->where('id', $id)
	    	             ->update($data);	

         	//Query For Deleting Previous Products
     		$delete_product = DB::table('tbl_coupons_products')
     				     		 ->where('coupon_id', $id)
     		                     ->delete();

         	foreach($request->input('products') as $row){
         		//Set Field data according to table column
	        	$data = array(
	        		'admin_id' => $request->session()->get('id'),
		        	'vendor_id' => 0,
		        	'coupon_id' => $id,
		        	'product_id' => $row,
		        	'ip_address' => $request->ip(),
		        	'created_date' => date('Y-m-d'),
	            	'created_time' => date('H:i:s'),
        		);

        		//Query For Inserting Data
		    	$query = DB::table('tbl_coupons_products')
		    	             ->insertGetId($data);
         	}

         	if(!empty($coupon_id == 0)){
                //Flash Erro Msg
                $request->session()->flash('alert-success', 'Coupon has been updated successfully');

                //Redirect
        		return redirect()->back();
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Something went wrong !!');

                //Redirect
        		return redirect()->back()->withInput($request->all());
            }
        }else{
        	//Set Field data according to table column
	        $data = array(
	        	'admin_id' => $request->session()->get('id'),
	        	'vendor_id' => 0,
	        	'ip_address' => $request->ip(),
	            'code' => $request->input('code'),
	            'discount_type' => $request->input('discount_type'),
	            'start_date' => date('Y-m-d', strtotime($request->input('start_date'))),
	            'end_date' => date('Y-m-d', strtotime($request->input('end_date'))),
	            'discount_offer' => $request->input('discount_offer'),
	            'no_of_uses' => $request->input('no_of_uses'),
	            'min_order_amount' => $request->input('min_order_amount'),
	            'max_order_amount' => $request->input('max_order_amount'),
	            'limit_per_customer' => $request->input('limit_per_customer'),
	            'order_type' => $request->input('order_type'),
	            'status' => $request->input('status'),
	            'created_date' => date('Y-m-d'),
	            'created_time' => date('H:i:s'),
	        );

	        //Query For Inserting Data
	    	$query = DB::table('tbl_coupons')
	    	             ->where('id', $id)
	    	             ->update($data);

     		if(!empty($query == 1)){
                //Flash Erro Msg
                $request->session()->flash('alert-success', 'Coupon has been updated successfully');

                //Redirect
        		return redirect()->back();
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Something went wrong !!');

                //Redirect
        		return redirect()->back()->withInput($request->all());
            }
        }
	}

	function delete(Request $request, $id){
		//Query For Deleting Coupon 
        $coupons = DB::table('tbl_coupons')
                       ->where('id', $id)
                       ->delete();

       	//Query For Checking If Products Exist on this coupon?
       	$query = DB::table('tbl_coupons_products')
				         ->where('coupon_id', $id)
				         ->orderBy('id', 'DESC');
        $products = $query->get();

        if(count($products) > 0){
        	//Query For Deleting Products
        	$coupons_products = DB::table('tbl_coupons_products')
	                       ->where('coupon_id', $id)
	                       ->delete();
        }

        //Check either data deleted or not
     	if(!empty($coupons || $coupons_products)){
     		//Flash Success Message
     		$request->session()->flash('alert-success', 'Coupon has been deleted successfully');
     	}else{
     		//Flash Error Message
     		$request->session()->flash('alert-danger', 'Something went wrong !!');
     	}

     	return redirect()->back();
	}

	function search(Request $request){
		//Header Data
    	$result = array(
            'page_title' => 'Search Records',
            'meta_keywords' => '',
            'meta_description' => '',
        ); 

    	//Query For Getting Coupons
        $query = DB::table('tbl_coupons')
        			 ->select('tbl_coupons.id', 'admin_id', 'code', 'discount_type', 'start_date', 'end_date', 'discount_offer', 'no_of_uses', 'min_order_amount', 'max_order_amount', 'limit_per_customer', 'order_type', 'tbl_coupons.status', 'tbl_coupons.created_date', 'first_name', 'last_name')
        			 ->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_coupons.vendor_id');
        			 if(!empty($request->input('name'))){
        	   $query->where('code', 'Like', '%'.$request->input('name').'%');
        			 }
        	   $query->orderBy('tbl_coupons.id', 'DESC');
	 	$result['query'] = $query->paginate(10);
 		$result['total_records'] = $result['query']->count();
 		
 		//Query For Getting All Admins
 		$query = DB::table('tbl_users')
 		             ->select('id', DB::raw("CONCAT(first_name, last_name) as admin_name"))
 		             ->where('status', 0);
     	$result['admins'] = $query->get();

    	//call page
        return view('admin.advertisements.coupons.manage', $result); 
	}
}