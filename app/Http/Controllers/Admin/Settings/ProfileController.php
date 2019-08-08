<?php
namespace App\Http\Controllers\Admin\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class ProfileController extends Controller{
	function edit(Request $request){
    	if(!empty($request->session()->has('id')) && $request->session()->get('role') == 0){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Manage Profile Settings',
	            'meta_keywords' => 'manage_profile_settings',
	            'meta_description' => 'manage_profile_settings',
	        );

	    	//Query for Getting Data
	    	$query = DB::table('tbl_users')
	    	             ->select('tbl_users.id', 'first_name', 'last_name', 'address', 'phone_no', 'email', 'country_id', 'city_id', 'dob', 'image', 'gender_id')
	    	             ->leftJoin('tbl_users_genders', 'tbl_users_genders.user_id', '=', 'tbl_users.id')
	    	             ->where('tbl_users.id', $request->session()->get('id'));
     		$result['query'] = $query->first();

     		//Query for Getting Countries
	    	$query = DB::table('tbl_countries')
	    	             ->select('id', 'country_code', 'country_name')
	    	             ->orderBy('id', 'DESC');
     		$result['countries'] = $query->get();
			
			//Query for Getting Cities
	    	$query = DB::table('tbl_cities')
	    	             ->select('id', 'name')
	    	             ->where('country_id', $result['query']->country_id)
	    	             ->orderBy('id', 'DESC');
     		$result['cities'] = $query->get();

	        //call page
	        return view('admin.settings.profile.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function update(Request $request){
    	if(!empty($request->session()->has('id')) && $request->session()->get('role') == 0){
    		//Inputs Validation
	        $input_validations = $request->validate([
	            'first_name' => 'required',
	            'last_name' => 'required',
	            'address' => 'required',
	            'phone_no' => 'required|unique:tbl_users,id,'.$request->session()->get('id'),
	            'city' => 'required|numeric',
	            'country' => 'required',
	            'city' => 'required|numeric',
	            'dob' => 'required',
	            'gender' => 'required|numeric',
	            'password' => 'nullable|min:8|regex:/^((?=.*[a-z]))((?=.*[A-Z]))((?=.*[0-9])).+$/',
	            'confirm_password' => 'nullable|min:8|regex:/^((?=.*[a-z]))((?=.*[A-Z]))((?=.*[0-9])).+$/|same:password',
	        	'profile' => 'nullable|mimes:jpeg,jpg,png|max:2000',
	        ]);
	        
	        if(!empty($request->input('password') && $request->input('confirm_password'))){
	        	//Set Field data according to table column
		        $data = array(
		        	'ip_address' => $request->ip(),
		        	'first_name' => $request->input('first_name'),
		        	'last_name' => $request->input('last_name'),
		        	'address' => $request->input('address'),
		        	'phone_no' => $request->input('phone_no'),
		        	'country_id' => $request->input('country'),
		        	'city_id' => $request->input('city'),
		        	'dob' => date('Y-m-d', strtotime($request->input('dob'))),
		        	'password' => sha1($request->input('confirm_password')),
		            'created_date' => date('Y-m-d'),
		        	'created_time' => date('h:i:s'),
		        );
	        }elseif(empty($request->input('password') && $request->input('confirm_password'))){
	        	//Set Field data according to table column
		        $data = array(
		        	'ip_address' => $request->ip(),
		        	'first_name' => $request->input('first_name'),
		        	'last_name' => $request->input('last_name'),
		        	'address' => $request->input('address'),
		        	'phone_no' => $request->input('phone_no'),
		        	'country_id' => $request->input('country'),
		        	'city_id' => $request->input('city'),
		        	'dob' => date('Y-m-d', strtotime($request->input('dob'))),
		        	'created_date' => date('Y-m-d'),
		        	'created_time' => date('h:i:s'),
		        );
			}

			//Query For Updating Data
	    	$user_details = DB::table('tbl_users')
	    	                    ->where('id', $request->session()->get('id'))
	    	                    ->update($data);

         	//Set Field data according to table column
	        $data = array(
	        	'ip_address' => $request->ip(),
	        	'gender_id' => $request->input('gender'),
        	);

    		//Query For Updating Gender
         	$gender_id = DB::table('tbl_users_genders')
	    	                 ->where('user_id', $request->session()->get('id'))
	    	                 ->update($data);

         	if($request->has('profile')){
         		//Upload Image
		        $image = time().'.'.$request->file('profile')->guessExtension();
		        $image_path = $request->file('profile')->move(public_path().'/assets/admin/images/profile_images/', $image);

         		//Set Field data according to table column
		        $data = array(
		        	'image' => $image,
	        	);

	    		//Query For Updating Gender
	         	$query = DB::table('tbl_users')
		    	             ->where('id', $request->session()->get('id'))
		    	             ->update($data);
         	}

         	//Check either data updated or not
	     	if($user_details == 1 || $gender_id == 1){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Profile has been updated successfully');
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
}