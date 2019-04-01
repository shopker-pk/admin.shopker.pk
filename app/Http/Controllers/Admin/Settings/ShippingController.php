<?php
namespace App\Http\Controllers\Admin\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class ShippingController extends Controller{
    function index(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Manage Shipping Areas',
	            'meta_keywords' => 'manage_shipping_areas',
	            'meta_description' => 'manage_shipping_areas',
	        );

	    	//Query for Getting Data
	    	$query = DB::table('tbl_shipping_areas')
	    	             ->select('tbl_shipping_areas.shipping_charges', 'tbl_shipping_areas.parent_id', 'tbl_shipping_areas.country_id', 'tbl_shipping_areas.status', 'tbl_countries.country_name')
	    	             ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_shipping_areas.country_id')
	    	             ->orderBy('tbl_shipping_areas.id', 'DESC')
	    	             ->where('tbl_shipping_areas.user_id', $request->session()->get('id'))
	    	             ->groupBy('tbl_shipping_areas.parent_id');
     		$result['query'] = $query->paginate(10);
     		$result['total_records'] = $result['query']->count();

	        //call page
	        return view('admin.settings.shipping_areas.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function add(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Add Shipping Areas',
	            'meta_keywords' => 'add_shipping_areas',
	            'meta_description' => 'add_shipping_areas',
	        );

	    	//Query for Getting Countries
	    	$query = DB::table('tbl_countries')
	    	             ->select('id', 'country_code', 'country_name')
	    	             ->orderBy('id', 'DESC');
     		$result['countries'] = $query->get();

	        //call page
	        return view('admin.settings.shipping_areas.add', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function insert(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Get All Inputs
        	$user_id = $request->session()->get('id');
        	$ip_address = $request->ip();
            $shipping_rate = $request->input('shipping_rate');
            $destination_country = $request->input('destination_country');
            $destination_city = $request->input('destination_city');
            $status = $request->input('status');
            $created_date = date('Y-m-d');
            $created_time = date('H:i:s');

        	//Inputs Validation
	        $input_validations = $request->validate([
	            'weight_unit' => 'nullable',
	            'shipping_rate' => 'nullable',
	            'destination_country' => 'nullable',
	            'destination_city' => 'nullable',
	            'status' => 'nullable',
	        ]);

	        //query for getting parent_id
	        $query = DB::table('tbl_shipping_areas')
	                     ->select('parent_id')
	                     ->orderBy('id', 'DESC');
         	$result = $query->first();

         	if(!empty($result)){
         		$parent_id = $result->parent_id + 1;
         	}else{
         		$parent_id = 0;
         	}

         	if(!empty($destination_city)){
		        foreach($destination_city as $row){
		        	//Set Field data according to table column
			        $data = array(
			        	'user_id' => $user_id,
			        	'ip_address' => $ip_address,
			        	'shipping_charges' => $shipping_rate,
			        	'parent_id' => $parent_id,
			        	'country_id' => $destination_country,
			        	'city_id' => $row,
			            'status' => $status,
			            'created_date' => $created_date,
			        	'created_time' => $created_time,
			        );

			        //Query For Inserting Data
			    	$query = DB::table('tbl_shipping_areas')
			    	             ->insertGetId($data);
	         	}
         	}else{
         		//Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		        	'shipping_charges' => $shipping_rate,
		        	'parent_id' => $parent_id,
		        	'country_id' => $destination_country,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Inserting Data
		    	$query = DB::table('tbl_shipping_areas')
		    	             ->insertGetId($data);
         	}

	        //Check either data inserted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Shipping Areas has been added successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('add_shipping_areas');
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function edit(Request $request, $id){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Edit Shipping Areas',
	            'meta_keywords' => 'edit_shipping_areas',
	            'meta_description' => 'edit_shipping_areas',
	        );

	    	//Query for Getting Data
	    	$query = DB::table('tbl_shipping_areas')
	    	             ->select('shipping_charges', 'parent_id', 'country_id', 'status')
	    	             ->where('user_id', $request->session()->get('id'))
	    	             ->where('parent_id', $id);
     		$result['query'] = $query->first();
     		
     		//Query for Getting shipping country
	    	$query = DB::table('tbl_shipping_areas')
	    	             ->select('*')
	    	             ->where('country_id', $result['query']->country_id)
	    	             ->where('user_id', $request->session()->get('id'))
	    	             ->where('parent_id', $id);
     		$result['query_cities'] = $query->get();

     		//Query for Getting Countries
	    	$query = DB::table('tbl_countries')
	    	             ->select('id', 'country_code', 'country_name')
	    	             ->orderBy('id', 'DESC');
     		$result['countries'] = $query->get();

     		//Query for Getting Cities
	    	$query = DB::table('tbl_cities')
	    	             ->select('id', 'country_id', 'name')
	    	             ->where('country_id', $result['query']->country_id)
	    	             ->orderBy('id', 'DESC');
     		$result['cities'] = $query->get();

     		if(!empty($result['query'])){
     			//call page
	        	return view('admin.settings.shipping_areas.edit', $result); 
     		}else{
     			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
     		}
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function update(Request $request, $id){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Get All Inputs
        	$user_id = $request->session()->get('id');
        	$ip_address = $request->ip();
            $shipping_rate = $request->input('shipping_rate');
            $destination_country = $request->input('destination_country');
            $destination_city = $request->input('destination_city');
            $status = $request->input('status');
            $created_date = date('Y-m-d');
            $created_time = date('H:i:s');

        	//Inputs Validation
	        $input_validations = $request->validate([
	            'weight_unit' => 'nullable',
	            'destination_country' => 'nullable',
	            'destination_city' => 'nullable',
	            'status' => 'nullable',
	        ]);

	        //Query for Deleting Data
	    	$query = DB::table('tbl_shipping_areas')
	    	             ->select('*')
	    	             ->where('user_id', $request->session()->get('id'))
	    	             ->where('parent_id', $id)
	    	             ->delete();

	        //query for getting parent_id
	        $query = DB::table('tbl_shipping_areas')
	                     ->select('parent_id')
	                     ->where('user_id', $request->session()->get('id'))
	                     ->orderBy('id', 'DESC');
         	$result = $query->first();

         	if(!empty($result)){
         		$parent_id = $result->parent_id + 1;
         	}else{
         		$parent_id = 0;
         	}

	        if(!empty($destination_city)){
		        foreach($destination_city as $row){
		        	//Set Field data according to table column
			        $data = array(
			        	'user_id' => $user_id,
			        	'ip_address' => $ip_address,
			        	'shipping_charges' => $shipping_rate,
			        	'parent_id' => $parent_id,
			        	'country_id' => $destination_country,
			        	'city_id' => $row,
			            'status' => $status,
			            'created_date' => $created_date,
			        	'created_time' => $created_time,
			        );

			        //Query For Inserting Data
			    	$query = DB::table('tbl_shipping_areas')
			    	             ->insertGetId($data);
	         	}
         	}else{
         		//Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		        	'shipping_charges' => $shipping_rate,
		        	'parent_id' => $parent_id,
		        	'country_id' => $destination_country,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Inserting Data
		    	$query = DB::table('tbl_shipping_areas')
		    	             ->insertGetId($data);
         	}

	        //Check either data updated or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Shipping Area has been updated successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('edit_shipping_areas', $id);
	    }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function delete(Request $request, $id){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
	   		//Query for Deleting Data
	    	$query = DB::table('tbl_shipping_areas')
	    	             ->select('*')
	    	             ->where('parent_id', $id)
	    	             ->where('user_id', $request->session()->get('id'))
	    	             ->delete();

	     	//Check either data deleted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Shipping Area has been deleted successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('manage_shipping_areas');
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function search(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Necessary Page Data For header Page
	        $result = array(
	            'page_title' => 'Search Records',
	            'meta_keywords' => 'search_records',
	            'meta_description' => 'search_records',
	        ); 

			//Query for Getting search Data
	    	$query = DB::table('tbl_shipping_areas')
	    	             ->select('tbl_shipping_areas.shipping_charges', 'tbl_shipping_areas.parent_id', 'tbl_shipping_areas.country_id', 'tbl_shipping_areas.status', 'tbl_countries.country_name')
	    	             ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_shipping_areas.country_id')
	    	             ->ORwhere('tbl_countries.country_name', 'LIKE', '%'.$request->input('name').'%')
						 ->ORwhere('shipping_charges', $request->input('name'))
						 ->where('status', $request->input('status'))
	    	             ->where('tbl_shipping_areas.user_id', $request->session()->get('id'))
	    	             ->orderBy('tbl_shipping_areas.id', 'DESC')
	    	             ->groupBy('tbl_shipping_areas.parent_id');
     		$result['query'] = $query->paginate(10);
     		$result['total_records'] = $result['query']->count();

	        //call page
	        return view('admin.settings.shipping_areas.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }
}