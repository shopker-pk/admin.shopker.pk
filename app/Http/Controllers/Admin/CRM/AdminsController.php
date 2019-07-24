<?php
namespace App\Http\Controllers\Admin\CRM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class AdminsController extends Controller{
	function index(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Manage Admins',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query For Getting Data
	        $query = DB::table('tbl_users')
	        			 ->select('tbl_users.id', 'first_name', 'last_name', 'address', 'phone_no', 'email', 'image', 'status', 'tbl_cities.name as city_name', 'tbl_countries.country_name')
	        			 ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_users.country_id')
	        			 ->leftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_users.city_id')
	        			 ->where('tbl_users.role', 1)
	        			 ->orderBy('tbl_users.id', 'DESC');
		 	$result['query'] = $query->paginate(10);
     		$result['total_records'] = $result['query']->count();

	        //call page
	        return view('admin.crm.admin.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

    function add(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
	    	//Header Data
	    	$result = array(
	            'page_title' => 'Add Admin',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	        //Query For Getting Countries
	        $query = DB::table('tbl_countries')
	                     ->select('*')
	                     ->orderBy('id', 'DESC');
         	$result['countries'] = $query->get();

	        //call page
	        return view('admin.crm.admin.add', $result); 
	    }else{
	    	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
    }

    function insert(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
	    	//Inputs Validation
	        $input_validations = $request->validate([
	            'first_name' => 'required',
	            'last_name' => 'required',
	            'phone_no' => 'required|max:13|min:11|unique:tbl_users',
	            'address' => 'required',
	            'country' => 'required',
	            'city' => 'required|numeric',
	            'email' => 'required|email|unique:tbl_users',
	            'password' => 'required|min:8|regex:/^((?=.*[a-z]))((?=.*[A-Z]))((?=.*[0-9])).+$/',
	            'permissions.*' => 'required|numeric',
	            'status' => 'required',
	        ]);

	        //Set Field data according to table column
	        $data = array(
	        	'ip_address' => $request->ip(),
	        	'varification_code' => rand(111111, 999999),
	        	'first_name' => $request->input('first_name'),
	        	'last_name' => $request->input('last_name'),
	        	'phone_no' => $request->input('phone_no'),
	        	'address' => $request->input('address'),
	        	'country_id' => $request->input('country'),
	        	'city_id' => $request->input('city'),
	        	'email' => $request->input('email'),
	        	'password' => sha1($request->input('password')),
	        	'image' => 'avatar.png',
	        	'role' => 1,
	        	'status' => $request->input('status'),
	            'created_date' => date('Y-m-d'),
	        	'created_time' => date('H:i:s'),
	        );

	        //Query For Inserting Data
	    	$admin_id = DB::table('tbl_users')
	    	             ->insertGetId($data);

 			foreach($request->input('permissions') as $row){
				//Set Field data according to table column
		        $data = array(
		        	'ip_address' => $request->ip(),
		        	'added_by' => $request->session()->get('id'),
		        	'admin_id' => $admin_id,
		        	'permission_id' => $row,
		            'created_date' => date('Y-m-d'),
		        	'created_time' => date('H:i:s'),
		        );

		        //Query For Inserting Data
		    	$query = DB::table('tbl_admin_permissions')
		    	             ->insertGetId($data);
			}

     		//Check either data inserted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Admin has been added successfully');

	     		//Redirect 
	     		return redirect()->back();
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');

	     		//Redirect 
	     		return redirect()->back()->withInput($request->all());
	     	}
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

            $query = DB::table('tbl_users')
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
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
	    	//Header Data
	    	$result = array(
	            'page_title' => 'Edit Admin',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query For Getting Data
	        $query = DB::table('tbl_users')
	        			 ->select('*')
	        			 ->where('id', $id);
		 	$result['query'] = $query->first();

		 	if(!empty($result['query'])){
		 		//Query For Getting Countries
		        $query = DB::table('tbl_countries')
		                     ->select('*')
		                     ->orderBy('id', 'DESC');
	         	$result['countries'] = $query->get();

	         	//Query For Getting Cities
		        $query = DB::table('tbl_cities')
		                     ->select('*')
		                     ->where('id', $result['query']->city_id);
	         	$result['cities'] = $query->get();

	         	//Query For Getting Permissions
		        $query = DB::table('tbl_admin_permissions')
		                     ->select('permission_id')
		                     ->where('admin_id', $result['query']->id);
	         	$permissions = $query->get();

	         	foreach($permissions as $row){
	         		$result['permission_'.$row->permission_id] = $row->permission_id;
	         	}
	         	
	         	//call page
	        	return view('admin.crm.admin.edit', $result); 
		 	}else{
		 		print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		 	}
	        
	    }else{
	    	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
    }

    function update(Request $request, $id){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
	    	//Inputs Validation
	        $input_validations = $request->validate([
	            'first_name' => 'required',
	            'last_name' => 'required',
	            'phone_no' => 'required|max:13|min:11|unique:tbl_users,id,'.$id,
	            'address' => 'required',
	            'country' => 'required',
	            'city' => 'required|numeric',
	            'email' => 'required|email|unique:tbl_users,id,'.$id,
	            'password' => 'nullable|min:8|regex:/^((?=.*[a-z]))((?=.*[A-Z]))((?=.*[0-9])).+$/',
	            'permissions.*' => 'required|numeric',
	            'status' => 'required',
	        ]);
         	
        	//Set Field data according to table column
	        $data = array(
	        	'ip_address' => $request->ip(),
	        	'varification_code' => rand(111111, 999999),
	        	'first_name' => $request->input('first_name'),
	        	'last_name' => $request->input('last_name'),
	        	'phone_no' => $request->input('phone_no'),
	        	'address' => $request->input('address'),
	        	'country_id' => $request->input('country'),
	        	'city_id' => $request->input('city'),
	        	'email' => $request->input('email'),
	        	'password' => sha1($request->input('password')),
	        	'image' => 'avatar.png',
	        	'role' => 1,
	        	'status' => $request->input('status'),
	            'created_date' => date('Y-m-d'),
	        	'created_time' => date('H:i:s'),
	        );

	        //Query For Inserting Data
	    	$query = DB::table('tbl_users')
	    		         ->where('id', $id)
	    	             ->update($data);

         	//Query For Deleting current permissions
         	$query = DB::table('tbl_admin_permissions')
         	             ->where('admin_id', $id)
         	             ->delete();

         	foreach($request->input('permissions') as $row){
				//Set Field data according to table column
		        $data = array(
		        	'ip_address' => $request->ip(),
		        	'added_by' => $request->session()->get('id'),
		        	'admin_id' => $id,
		        	'permission_id' => $row,
		            'created_date' => date('Y-m-d'),
		        	'created_time' => date('H:i:s'),
		        );

		        //Query For Inserting Data
		    	$permissions = DB::table('tbl_admin_permissions')
		    	             ->insertGetId($data);
			}

	     	//Check either data inserted or not
	     	if(!empty($query == 1 && $permissions)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Admin has been updated successfully');

	     		//Redirect 
	     		return redirect()->back();
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');

	     		//Redirect 
	     		return redirect()->back()->withInput($request->all());
	     	}
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function delete(Request $request, $id){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
    		//Query For Deleting User
    		$user = DB::table('tbl_users')
    		             ->where('id', $id)
    		             ->delete();

         	//Query For Deleting User Permissions
    		$permission = DB::table('tbl_admin_permissions')
    		             ->where('admin_id', $id)
    		             ->delete();

         	//Check either data deleted or not
	     	if(!empty($user && $permission)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'User has been deleted successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('manage_pages');
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
			$query = DB::table('tbl_users')
	                     ->select('tbl_users.id', 'first_name', 'last_name', 'address', 'phone_no', 'email', 'image', 'status', 'tbl_cities.name as city_name', 'tbl_countries.country_name')
	        			 ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_users.country_id')
	        			 ->leftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_users.city_id');
	        			 if(!empty($request->input('name'))){
	  			 $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'Like', '%'.$request->input('name').'%');
	        			 }
	        			 if(!empty($request->input('email'))){
	        	  $query->where('email', 'Like', '%'.$request->input('email').'%');
	        			 }
	        			 if(!empty($request->input('status') != 2)){
	        	  $query->where('status', $request->input('status'));
	        			 } 
	              $query->where('tbl_users.role', 1)
	                    ->orderBy('tbl_users.id', 'DESC');
	        $result['query'] = $query->paginate(10);
     		$result['total_records'] = $query->count();

	        //call page
	 		return view('admin.crm.admin.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }
}