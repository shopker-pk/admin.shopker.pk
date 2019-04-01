<?php
namespace App\Http\Controllers\Admin\Ecommerce;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class CategoriesController extends Controller{
	function view_parent_categories(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
    		//Header Data
	    	$result = array(
	            'page_title' => 'Manage Parent Categories',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	if(!empty($request->input('per_page'))){
    			$per_page = $request->input('per_page');
    		}else{
	    		$per_page = 10;
	    	}

	    	//Query for Getting Data
	    	$query = DB::table('tbl_parent_categories')
	    	             ->select('id', 'name', 'status')
	    	             ->orderBy('id', 'DESC');
     		$result['query'] = $query->paginate($per_page);
     		$result['total_records'] = $result['query']->count();

	        //call page
	        return view('admin.ecommerce.categories.parent.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function add_parent_categories(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Add Parent Categories',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//call page
	        return view('admin.ecommerce.categories.parent.add', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function insert_parent_categories(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $request->input('name'))){
	    	//Get All Inputs
        	$user_id = $request->session()->get('id');
        	$ip_address = $request->ip();
        	$image = $request->file('image');
            $name = $request->input('name');
        	$slug = strtolower(str_replace(' ', '-', $request->input('name')));
            $meta_keywords = $request->input('meta_keywords');
            $meta_description = $request->input('meta_description');
            $status = $request->input('status', '0');
            $created_date = date('Y-m-d');
            $created_time = date('H:i:s');

	        //Inputs Validation
	        $input_validations = $request->validate([
	        	'image' => 'nullable|mimes:jpeg,jpg,png|max:2000|', //dimensions:max_width=300,max_height:200',
	            'name' => 'required|unique:tbl_parent_categories',
	            'slug' => 'nullable|unique:tbl_parent_categories',
	            'meta_keywords' => 'nullable',
	            'meta_description' => 'nullable',
	            'status' => 'required',
	        ]);

	        if(!empty($image)){
		        //Upload Image
		        $featured_image = time().'.'.$image->guessExtension();
		        $image_path = $image->move(public_path().'/assets/admin/images/ecommerce/categories/', $featured_image);
		        
		        //Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		        	'featured_image' => $featured_image,
		            'name' => $name,
		        	'slug' => $slug,
		        	'meta_keywords' => $meta_keywords,
		        	'meta_description' => $meta_description,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Inserting Data
		    	$query = DB::table('tbl_parent_categories')
		    	             ->insertGetId($data);
         	}else{
         		//Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		            'name' => $name,
		        	'slug' => $slug,
		        	'meta_keywords' => $meta_keywords,
		        	'meta_description' => $meta_description,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Inserting Data
		    	$query = DB::table('tbl_parent_categories')
		    	             ->insertGetId($data);
         	}

	     	//Check either data inserted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Category has been added successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('add_parent_categories');
	    }else{
    		print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function ajax_update_parent_status(Request $request, $id, $status){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
            if($status == 0){
                $status = 1;
            }elseif($status == 1){
                $status = 0;
            }

            $query = DB::table('tbl_parent_categories')
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

	function edit_parent_categories(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Edit Categories',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query for Getting Data
	    	$query = DB::table('tbl_parent_categories')
	    	             ->select('*')
	    	             ->where('id', $id);
         	$result['query'] = $query->first();
         	
         	if(!empty($result['query'])){
         		//call page
		        return view('admin.ecommerce.categories.parent.edit', $result); 
	    	}else{
	    		print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
	    	}
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function update_parent_categories(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
			//Get All Inputs
        	$user_id = $request->session()->get('id');
        	$ip_address = $request->ip();
        	$image = $request->file('image');
            $name = $request->input('name');
        	$slug = strtolower(str_replace(' ', '-', $request->input('name')));
			$meta_keywords = $request->input('meta_keywords');
            $meta_description = $request->input('meta_description');
            $status = $request->input('status', '0');
            $created_date = date('Y-m-d');
            $created_time = date('H:i:s');

	        //Inputs Validation
	        $input_validations = $request->validate([
	        	'image' => 'nullable|mimes:jpeg,jpg,png|max:2000|', //dimensions:max_width=300,max_height:200',
	            'name' => 'required|unique:tbl_parent_categories,id,'.$id,
	            'slug' => 'nullable|unique:tbl_parent_categories,id,'.$id,
	            'meta_keywords' => 'nullable',
	            'meta_description' => 'nullable',
	            'status' => 'required',
	        ]);

	        if(!empty($image)){
			    //Upload Image
			    $featured_image = time().'.'.$image->guessExtension();
			    $image_path = $image->move(public_path().'/assets/admin/images/ecommerce/categories/', $featured_image);
			    
			    //Set Field data according to table column
			    $data = array(
			    	'user_id' => $user_id,
			    	'ip_address' => $ip_address,
			    	'featured_image' => $featured_image,
		        	'name' => $name,
		        	'slug' => $slug,
		        	'meta_keywords' => $meta_keywords,
		        	'meta_description' => $meta_description,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );
		        
		        //Query For Updating Data
		    	$query = DB::table('tbl_parent_categories')
		    	             ->where('id', $id)
		    	             ->update($data);
         	}else{
         		//Set Field data according to table column
			    $data = array(
			    	'user_id' => $user_id,
			    	'ip_address' => $ip_address,
		        	'name' => $name,
		        	'slug' => $slug,
		        	'meta_keywords' => $meta_keywords,
		        	'meta_description' => $meta_description,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );
		        
		        //Query For Updating Data
		    	$query = DB::table('tbl_parent_categories')
		    	             ->where('id', $id)
		    	             ->update($data);
         	}

	     	//Check either data updated or not
	     	if(!empty($query == 1)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Category has been updated successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('edit_parent_categories', $id);
		}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function delete_parent_categories(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
			//Query For Deleting Data
			$query = DB::table('tbl_parent_categories')
			             ->where('id', $id)
			             ->delete();

         	//Check either data deleted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Category has been deleted successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->back();
		}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function search_parent_categories(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
			//Necessary Page Data For header Page
	        $result = array(
	            'page_title' => 'Search Records',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        ); 

	        if(!empty($request->input('per_page'))){
    			$per_page = $request->input('per_page');
    		}else{
	    		$per_page = 10;
	    	}

			//Query For Getting Search Data
			$query = DB::table('tbl_parent_categories')
	                     ->select('*');
	                     if(!empty($request->input('name'))){
                   $query->where('name', 'Like', '%'.$request->input('name').'%');
	                     }
	                     if(!empty($request->input('status'))){
                   $query->where('status', $request->input('status'));
	                     }
	               $query->orderBy('id', 'DESC');
	        $result['query'] = $query->paginate($per_page);
     		$result['total_records'] = $result['query']->count();

	        //call page
	 		return view('admin.ecommerce.categories.parent.manage', $result); 
 		}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function view_child_categories(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
	    	//Header Data
	    	$result = array(
	            'page_title' => 'Manage child Categories',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query for Getting Data
	    	$query = DB::table('tbl_child_categories')
	    	             ->select('id', 'name', 'status')
	    	             ->orderBy('id', 'DESC');
	 		$result['query'] = $query->paginate(10);
	 		$result['total_records'] = $result['query']->count();

	        //call page
	        return view('admin.ecommerce.categories.child.manage', $result); 
	    }else{
	    	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

	function add_child_categories(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Add child Categories',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query For Getting Categories
	        $query = DB::table('tbl_parent_categories')
	        			 ->select('id', 'name')
	        			 ->where('status', 0)
	        			 ->orderBy('id', 'DESC');
		 	$result['parent_categories'] = $query->get();

	    	//call page
	        return view('admin.ecommerce.categories.child.add', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function insert_child_categories(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $request->input('name'))){
	    	//Get All Inputs
        	$user_id = $request->session()->get('id');
        	$ip_address = $request->ip();
        	$image = $request->file('image');
        	$parent_category = $request->input('parent_category');
            $name = $request->input('name');
        	$slug = strtolower(str_replace(' ', '-', $request->input('name')));
            $meta_keywords = $request->input('meta_keywords');
            $meta_description = $request->input('meta_description');
            $status = $request->input('status', '0');
            $created_date = date('Y-m-d');
            $created_time = date('H:i:s');

	        //Inputs Validation
	        $input_validations = $request->validate([
	        	'image' => 'nullable|mimes:jpeg,jpg,png|max:2000|', //dimensions:max_width=300,max_height:200',
	        	'parent_category' => 'required',
	            'name' => 'required|unique:tbl_child_categories',
	            'slug' => 'nullable|unique:tbl_child_categories',
	            'parent_category' => 'required',
	            'meta_keywords' => 'nullable',
	            'meta_description' => 'nullable',
	            'status' => 'required',
	        ]);

	        if(!empty($image)){
		        //Upload Image
		        $featured_image = time().'.'.$image->guessExtension();
		        $image_path = $image->move(public_path().'/assets/admin/images/ecommerce/categories/', $featured_image);
		        
		        //Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		        	'featured_image' => $featured_image,
		            'parent_id' => $parent_category,
		            'name' => $name,
		        	'slug' => $slug,
		        	'meta_keywords' => $meta_keywords,
		        	'meta_description' => $meta_description,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Inserting Data
		    	$query = DB::table('tbl_child_categories')
		    	             ->insertGetId($data);
         	}else{
         		//Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		            'parent_id' => $parent_category,
		            'name' => $name,
		        	'slug' => $slug,
		        	'meta_keywords' => $meta_keywords,
		        	'meta_description' => $meta_description,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Inserting Data
		    	$query = DB::table('tbl_child_categories')
		    	             ->insertGetId($data);
         	}

	     	//Check either data inserted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Category has been added successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('add_child_categories');
	    }else{
    		print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function ajax_update_child_status(Request $request, $id, $status){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
            if($status == 0){
                $status = 1;
            }elseif($status == 1){
                $status = 0;
            }

            $query = DB::table('tbl_child_categories')
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

	function edit_child_categories(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Edit Child Categories',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query for Getting Data
	    	$query = DB::table('tbl_child_categories')
	    	             ->select('*')
	    	             ->where('id', $id);
         	$result['query'] = $query->first();
         	
         	//Query for Getting Parent Categories
     		$query = DB::table('tbl_parent_categories')
	        			 ->select('id', 'name')
	        			 ->where('status', 0)
	        			 ->orderBy('id', 'DESC');
		 	$result['parent_categories'] = $query->get();

         	if(!empty($result['query'])){
         		//explode parent categories of this category
         		$result['query_categories'] = $result['query']->parent_id;

		        //call page
		        return view('admin.ecommerce.categories.child.edit', $result); 
	    	}else{
	    		print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
	    	}
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function update_child_categories(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
			//Get All Inputs
        	$user_id = $request->session()->get('id');
        	$ip_address = $request->ip();
        	$image = $request->file('image');
        	$parent_category = $request->input('parent_category');
            $name = $request->input('name');
        	$slug = strtolower(str_replace(' ', '-', $request->input('name')));
			$meta_keywords = $request->input('meta_keywords');
            $meta_description = $request->input('meta_description');
            $status = $request->input('status', '0');
            $created_date = date('Y-m-d');
            $created_time = date('H:i:s');

	        //Inputs Validation
	        $input_validations = $request->validate([
	        	'image' => 'nullable|mimes:jpeg,jpg,png|max:2000|', //dimensions:max_width=300,max_height:200',
	            'name' => 'required|unique:tbl_child_categories,id,'.$id,
	            'slug' => 'nullable|unique:tbl_child_categories,id,'.$id,
	            'parent_category' => 'required',
	            'meta_keywords' => 'nullable',
	            'meta_description' => 'nullable',
	            'status' => 'required',
	        ]);

	        if(!empty($image)){
			    //Upload Image
			    $featured_image = time().'.'.$image->guessExtension();
			    $image_path = $image->move(public_path().'/assets/admin/images/ecommerce/categories/', $featured_image);
			    
			    //Set Field data according to table column
			    $data = array(
			    	'user_id' => $user_id,
			    	'ip_address' => $ip_address,
			    	'featured_image' => $featured_image,
			    	'parent_id' => $parent_category,
		        	'name' => $name,
		        	'slug' => $slug,
		        	'meta_keywords' => $meta_keywords,
		        	'meta_description' => $meta_description,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );
		        
		        //Query For Updating Data
		    	$query = DB::table('tbl_child_categories')
		    	             ->where('id', $id)
		    	             ->update($data);
         	}else{
         		//Set Field data according to table column
			    $data = array(
			    	'user_id' => $user_id,
			    	'ip_address' => $ip_address,
			    	'parent_id' => $parent_category,
		        	'name' => $name,
		        	'slug' => $slug,
		        	'meta_keywords' => $meta_keywords,
		        	'meta_description' => $meta_description,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );
		        
		        //Query For Updating Data
		    	$query = DB::table('tbl_child_categories')
		    	             ->where('id', $id)
		    	             ->update($data);
         	}

	     	//Check either data updated or not
	     	if(!empty($query == 0)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Category has been updated successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('edit_child_categories', $id);
		}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function delete_child_categories(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
			//Query For Deleting Data
			$query = DB::table('tbl_child_categories')
			             ->where('id', $id)
			             ->delete();

         	//Check either data deleted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Category has been deleted successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->back();
		}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function search_child_categories(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
			//Necessary Page Data For header Page
	        $result = array(
	            'page_title' => 'Search Records',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        ); 

			//Query For Getting Search Data
			$query = DB::table('tbl_child_categories')
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
	 		return view('admin.ecommerce.categories.child.manage', $result); 
 		}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}


	function view_sub_child_categories(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
	    	//Header Data
	    	$result = array(
	            'page_title' => 'Manage sub_child Categories',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query for Getting Data
	    	$query = DB::table('tbl_sub_child_categories')
	    	             ->select('id', 'name', 'status')
	    	             ->orderBy('id', 'DESC');
	 		$result['query'] = $query->paginate(10);
	 		$result['total_records'] = $result['query']->count();

	        //call page
	        return view('admin.ecommerce.categories.sub_child.manage', $result); 
	    }else{
	    	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

	function add_sub_child_categories(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Add sub_child Categories',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query For Getting Parent Categories
	        $query = DB::table('tbl_parent_categories')
	        			 ->select('id', 'name')
	        			 ->where('status', 0)
	        			 ->orderBy('id', 'DESC');
		 	$result['parent_categories'] = $query->get();

	    	//call page
	        return view('admin.ecommerce.categories.sub_child.add', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function get_child_categories(Request $request, $id){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            $ajax_response_data = array(
                'ERROR' => 'FALSE',
                'DATA' => '',
            );

            $query = DB::table('tbl_child_categories')
                         ->select('id', 'name')
                         ->where('parent_id', $id)
                         ->where('status', 0);
            $result = $query->get();

            $html = '';
            if(!empty($result->count() > 0)){
                foreach($result as $row){
                    $html .= '<option value='.$row->id.'>'.$row->name.'</option>';
                }    

                $ajax_response_data = array(
                    'ERROR' => 'FALSE',
                    'DATA' => '<option>No child cateogry selected</option>'.$html,
                );

                echo json_encode($ajax_response_data);
            }else{
            	$ajax_response_data = array(
                    'ERROR' => 'TRUE',
                    'DATA' => '',
                );

                echo json_encode($ajax_response_data);
            }
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
        die;
    }

    function insert_sub_child_categories(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $request->input('name'))){
	    	//Get All Inputs
        	$user_id = $request->session()->get('id');
        	$ip_address = $request->ip();
        	$image = $request->file('image');
        	$parent_category = $request->input('parent_category');
        	$child_category = $request->input('child_category');
            $name = $request->input('name');
        	$slug = strtolower(str_replace(' ', '-', $request->input('name')));
            $meta_keywords = $request->input('meta_keywords');
            $meta_description = $request->input('meta_description');
            $status = $request->input('status', '0');
            $created_date = date('Y-m-d');
            $created_time = date('H:i:s');

	        //Inputs Validation
	        $input_validations = $request->validate([
	        	'image' => 'nullable|mimes:jpeg,jpg,png|max:2000|', //dimensions:max_width=300,max_height:200',
	        	'parent_category' => 'required',
	        	'child_category' => 'required',
	            'name' => 'required|unique:tbl_sub_child_categories',
	            'slug' => 'nullable|unique:tbl_sub_child_categories',
	            'meta_keywords' => 'nullable',
	            'meta_description' => 'nullable',
	            'status' => 'required',
	        ]);

	        if(!empty($image)){
		        //Upload Image
		        $featured_image = time().'.'.$image->guessExtension();
		        $image_path = $image->move(public_path().'/assets/admin/images/ecommerce/categories/', $featured_image);
		        
		        //Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		        	'featured_image' => $featured_image,
		            'parent_id' => $parent_category,
		            'child_id' => $child_category,
		            'name' => $name,
		        	'slug' => $slug,
		        	'meta_keywords' => $meta_keywords,
		        	'meta_description' => $meta_description,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Inserting Data
		    	$query = DB::table('tbl_sub_child_categories')
		    	             ->insertGetId($data);
         	}else{
         		//Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		            'parent_id' => $parent_category,
		            'child_id' => $child_category,
		            'name' => $name,
		        	'slug' => $slug,
		        	'meta_keywords' => $meta_keywords,
		        	'meta_description' => $meta_description,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Inserting Data
		    	$query = DB::table('tbl_sub_child_categories')
		    	             ->insertGetId($data);
         	}

	     	//Check either data inserted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Category has been added successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('add_sub_child_categories');
	    }else{
    		print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function ajax_update_sub_child_status(Request $request, $id, $status){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
            if($status == 0){
                $status = 1;
            }elseif($status == 1){
                $status = 0;
            }

		    $query = DB::table('tbl_sub_child_categories')
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

	function edit_sub_child_categories(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Edit Sub Child Categories',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query for Getting Data
	    	$query = DB::table('tbl_sub_child_categories')
	    	             ->select('*')
	    	             ->where('id', $id);
         	$result['query'] = $query->first();
         	
         	if(!empty($result['query'])){
         		//explode parent categories of this category
         		$result['query_parent_category'] = $result['query']->parent_id;
         		$result['query_child_category'] = $result['query']->child_id;

         		//Query For Getting Parent Categories
		        $query = DB::table('tbl_parent_categories')
		        			 ->select('id', 'name')
		        			 ->where('status', 0)
		        			 ->orderBy('id', 'DESC');
			 	$result['parent_categories'] = $query->get();

			 	//Query For Getting Child Categories
		        $query = DB::table('tbl_child_categories')
		        			 ->select('id', 'name')
		        			 ->where('parent_id', $result['query']->parent_id)
		        			 ->where('status', 0)
		        			 ->orderBy('id', 'DESC');
			 	$result['child_categories'] = $query->get();

		        //call page
		        return view('admin.ecommerce.categories.sub_child.edit', $result); 
	    	}else{
	    		print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
	    	}
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function update_sub_child_categories(Request $request, $id){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $request->input('name'))){
	    	//Get All Inputs
        	$user_id = $request->session()->get('id');
        	$ip_address = $request->ip();
        	$image = $request->file('image');
        	$parent_category = $request->input('parent_category');
        	$child_category = $request->input('child_category');
            $name = $request->input('name');
        	$slug = strtolower(str_replace(' ', '-', $request->input('name')));
            $meta_keywords = $request->input('meta_keywords');
            $meta_description = $request->input('meta_description');
            $status = $request->input('status', '0');
            $created_date = date('Y-m-d');
            $created_time = date('H:i:s');

	        //Inputs Validation
	        $input_validations = $request->validate([
	        	'image' => 'nullable|mimes:jpeg,jpg,png|max:2000|', //dimensions:max_width=300,max_height:200',
	        	'parent_category' => 'required',
	        	'child_category' => 'required',
	            'name' => 'required|unique:tbl_sub_child_categories,id,'.$id,
	            'slug' => 'nullable|unique:tbl_sub_child_categories,id,'.$id,
	            'meta_keywords' => 'nullable',
	            'meta_description' => 'nullable',
	            'status' => 'required',
	        ]);

	        if(!empty($image)){
		        //Upload Image
		        $featured_image = time().'.'.$image->guessExtension();
		        $image_path = $image->move(public_path().'/assets/admin/images/ecommerce/categories/', $featured_image);
		        
		        //Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		        	'featured_image' => $featured_image,
		            'parent_id' => $parent_category,
		            'child_id' => $child_category,
		            'name' => $name,
		        	'slug' => $slug,
		        	'meta_keywords' => $meta_keywords,
		        	'meta_description' => $meta_description,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Updating Data
		    	$query = DB::table('tbl_sub_child_categories')
		    	             ->where('id', $id)
		    	             ->update($data);
         	}else{
         		//Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		            'parent_id' => $parent_category,
		            'child_id' => $child_category,
		            'name' => $name,
		        	'slug' => $slug,
		        	'meta_keywords' => $meta_keywords,
		        	'meta_description' => $meta_description,
		            'status' => $status,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Updating Data
		    	$query = DB::table('tbl_sub_child_categories')
		    	             ->where('id', $id)
		    	             ->update($data);
         	}

	     	//Check either data inserted or not
	     	if(!empty($query == 0)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Category has been updated successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('edit_sub_child_categories', $id);
	    }else{
    		print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function delete_sub_child_categories(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
			//Query For Deleting Data
			$query = DB::table('tbl_sub_child_categories')
			             ->where('id', $id)
			             ->delete();

         	//Check either data deleted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Category has been deleted successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->back();
		}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function search_sub_child_categories(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
			//Necessary Page Data For header Page
	        $result = array(
	            'page_title' => 'Search Records',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        ); 

			//Query For Getting Search Data
			$query = DB::table('tbl_sub_child_categories')
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
	 		return view('admin.ecommerce.categories.sub_child.manage', $result); 
 		}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}
}