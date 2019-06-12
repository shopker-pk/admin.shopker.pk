<?php
namespace App\Http\Controllers\Admin\Ecommerce;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class BrandsController extends Controller{
    function index(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Manage Brands',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query for Getting Data
	    	$query = DB::table('tbl_brands_for_products')
	    	             ->select('id', 'name', 'image', 'status')
	    	             ->orderBy('id', 'DESC');
     		$result['query'] = $query->paginate(10);
     		$result['total_records'] = $result['query']->count();

	        //call page
	        return view('admin.ecommerce.brands.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function add(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Add Brands',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	        //call page
	        return view('admin.ecommerce.brands.add', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function insert(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $request->input('name'))){
	    	//Get All Inputs
        	$user_id = $request->session()->get('id');
        	$ip_address = $request->ip();
            $name = $request->input('name');
        	$slug = strtolower(str_replace(' ', '-', $request->input('name')));
            $image = $request->file('image');
            $status = $request->input('status', '0');
            $created_date = date('Y-m-d');
            $created_time = date('H:i:s');

	        //Inputs Validation
	        $input_validations = $request->validate([
	            'name' => 'required|unique:tbl_brands_for_products',
	            'slug' => 'nullable|unique:tbl_brands_for_products',
	            'image' => 'nullable|mimes:jpeg,jpg,png|max:2000|', //dimensions:max_width=300,max_height:200',
	            'status' => 'required',
	        ]);

	        if(!empty($image)){
		        //Upload Image
		        $brand_image = time().'.'.$image->guessExtension();
		        $image_path = $image->move(public_path().'/assets/admin/images/ecommerce/brands/', $brand_image);

		        //Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		        	'image' => $brand_image,
		            'name' => $name,
		        	'slug' => $slug,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Inserting Data
		    	$query = DB::table('tbl_brands_for_products')
		    	             ->insertGetId($data);
         	}else{
         		//Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		        	'image' => '',
		            'name' => $name,
		        	'slug' => $slug,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Inserting Data
		    	$query = DB::table('tbl_brands_for_products')
		    	             ->insertGetId($data);	
         	}

	     	//Check either data inserted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Brand has been added successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('add_brands');
	    }else{
    		print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function ajax_update_status(Request $request, $id, $status){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
            if($status == 0){
                $status = 1;
            }elseif($status == 1){
                $status = 0;
            }

            $query = DB::table('tbl_brands_for_products')
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
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
	}

	function edit(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Edit Brands',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query for Getting Data
	    	$query = DB::table('tbl_brands_for_products')
	    	             ->select('*')
	    	             ->where('id', $id);
         	$result['query'] = $query->first();

         	if(!empty($result['query'])){
         		//call page
		        return view('admin.ecommerce.brands.edit', $result); 
	    	}else{
	    		print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
	    	}
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function update(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
			//Get All Inputs
        	$user_id = $request->session()->get('id');
        	$ip_address = $request->ip();
            $name = $request->input('name');
        	$slug = strtolower(str_replace(' ', '-', $request->input('name')));
            $image = $request->file('image');
            $status = $request->input('status', '0');
            $created_date = date('Y-m-d');
            $created_time = date('H:i:s');

	        //Inputs Validation
	        $input_validations = $request->validate([
	            'name' => 'required|unique:tbl_brands_for_products,id,'.$id,
	            'slug' => 'nullable|unique:tbl_brands_for_products,id,'.$id,
	            'image' => 'nullable|mimes:jpeg,jpg,png|max:2000|', //dimensions:max_width=300,max_height:200',
	            'status' => 'required',
	        ]);

	        if(!empty($image)){
	        	//Upload Image
		        $brand_image = time().'.'.$image->guessExtension();
		        $image_path = $image->move(public_path().'/assets/admin/images/ecommerce/brands/', $brand_image);

		        //Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		        	'image' => $brand_image,
		            'name' => $name,
		        	'slug' => $slug,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );
	        }else{
        		//Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		            'name' => $name,
		        	'slug' => $slug,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );
	        }
	        

	        //Query For Updating Data
	    	$query = DB::table('tbl_brands_for_products')
	    	             ->where('id', $id)
	    	             ->update($data);

	     	//Check either data updated or not
	     	if(!empty($query == 1)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Brand has been updated successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('edit_brands', $id);
		}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function delete(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
			//Query For Deleting Data
			$query = DB::table('tbl_brands_for_products')
			             ->where('id', $id)
			             ->delete();

         	//Check either data deleted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Brand has been deleted successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('manage_brands');
		}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function search(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
			//Necessary Page Data For header Page
	        $result = array(
	            'page_title' => 'Search Records',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        ); 

			//Query For Getting Search Data
			$query = DB::table('tbl_brands_for_products')
	                     ->select('*');
                     	 if(!empty($request->input('name'))){
                   $query->where('name', 'Like', '%'.$request->input('name').'%');
                     	 }
	                     if(!empty($request->input('status'))){
                   $query->where('status', $request->input('status'));
                     	 }
	               $query->orderBy('id', 'DESC');
	        $result['query'] = $query->paginate(10);
     		$result['total_records'] = $result['query']->count();

	        //call page
	 		return view('admin.ecommerce.brands.manage', $result); 
 		}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}
}