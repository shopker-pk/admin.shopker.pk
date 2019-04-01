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
	    	             ->select('tbl_users.id as u_id', 'first_name', 'last_name', 'cnic', 'date_of_birth', 'gender', 'country_id', 'city_id', 'address', 'country_code_1', 'cell_number1', 'country_code_2', 'cell_number2', 'password', 'image', 'tbl_users_social_profile.id as u_s_id', 'user_id', 'facebook', 'twitter', 'googleplus')
	    	             ->leftJoin('tbl_users_social_profile', 'tbl_users_social_profile.user_id', '=', 'tbl_users.id')
	    	             ->where('tbl_users.id', $request->session()->get('id'));
     		$result['query'] = $query->first();

     		//Query For Getting Country codes
	 		$query = DB::table('tbl_countries_phone_code')
	    	             ->select('*');
	 		$result['country_code'] = $query->get();

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

	        //call page
	        return view('admin.settings.profile.edit', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function update(Request $request){
    	if(!empty($request->session()->has('id')) && $request->session()->get('role') == 0){
    		if($request->input('btn') == 0){
	    		//Get All Inputs
	        	$ip_address = $request->ip();
	            $first_name = $request->input('first_name');
	        	$last_name = $request->input('last_name');
	            $cnic = $request->input('cnic');
	            $date_of_birth = $request->input('dob');
	            $gender = $request->input('gender');
	            $country = $request->input('country');
	            $city = $request->input('city');
	            $address = $request->input('address');
	            $created_date = date('Y-m-d');
	            $created_time = date('H:i:s');

	            //Inputs Validation
		        $input_validations = $request->validate([
		            'first_name' => 'nullable',
		            'last_name' => 'nullable',
		            'cnic' => 'nullable|regex:/^[0-9]{13}$/|unique:tbl_users',
		            'dob' => 'nullable',
		            'gender' => 'nullable',
		            'country' => 'nullable',
		            'city' => 'nullable',
		            'address' => 'nullable',
		        ]);

		        //Set Field data according to table column
		        $data = array(
		        	'ip_address' => $ip_address,
		        	'first_name' => $first_name,
		        	'last_name' => $last_name,
		        	'cnic' => $cnic,
		        	'address' => $address,
		        	'date_of_birth' => $date_of_birth,
		        	'gender' => $gender,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Updating Data
		    	$query = DB::table('tbl_users')
		    	             ->where('id', $request->session()->get('id'))
		    	             ->update($data);
        		
        		//Check either data updated or not
		     	if($query){
		     		//Flash Success Message
		     		$request->session()->flash('alert-success', 'Profile Settings has been updated successfully');
		     	}else{
		     		//Flash Error Message
		     		$request->session()->flash('alert-danger', 'Something went wrong !!');
		     	}
	    		
	    		//Redirect 
		     	return redirect()->route('admin_profile_settings');
	     	}elseif($request->input('btn') == 1){
	     		//Get All Inputs
	        	$ip_address = $request->ip();
	            $country_code_1 = $request->input('code_1');
	            $cell_number1 = $request->input('cell_number1');
	            $country_code_2 = $request->input('code_2');
	            $cell_number2 = $request->input('cell_number2');
	            $created_date = date('Y-m-d');
	            $created_time = date('H:i:s');

	            //Inputs Validation
		        $input_validations = $request->validate([
		        	'code_1' => 'nullable',
		            'cell_number1' => 'nullable|regex:/^[0-9]{10}$/|unique:tbl_users',
		            'code_2' => 'nullable',
        			'cell_number2' => 'nullable|regex:/^[0-9]{10}$/|unique:tbl_users',
		        ]);

		        //Set Field data according to table column
		        $data = array(
		        	'ip_address' => $ip_address,
		        	'country_code_1' => $country_code_1,
		        	'cell_number1' => $cell_number1,
		        	'country_code_2' => $country_code_2,
		        	'cell_number2' => $cell_number2,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );

		        //Query For Updating Data
		    	$query = DB::table('tbl_users')
		    	             ->where('id', $request->session()->get('id'))
		    	             ->update($data);
        		
        		//Check either data updated or not
		     	if($query){
		     		//Flash Success Message
		     		$request->session()->flash('alert-success', 'Contact Details has been updated successfully');
		     	}else{
		     		//Flash Error Message
		     		$request->session()->flash('alert-danger', 'Something went wrong !!');
		     	}

		     	//Redirect 
		     	return redirect()->route('admin_profile_settings');
	     	}elseif($request->input('btn') == 2){
	     		//Get All Inputs
	        	$ip_address = $request->ip();
	            $password = sha1($request->input('password'));
	            $confirm_password = sha1($request->input('confirm_password'));
	            $created_date = date('Y-m-d');
	            $created_time = date('H:i:s');

	            //Inputs Validation
		        $input_validations = $request->validate([
		        	'password' => 'nullable|min:8|regex:/^((?=.*[a-z]))((?=.*[0-9])).+$/',
        			'confirm_password' => 'nullable|min:8|regex:/^((?=.*[a-z]))((?=.*[0-9])).+$/',
		        ]);

	        	//if password not matched then update other info
        		if($password <=> $confirm_password){
        			//Flash Error Message
		     		$request->session()->flash('alert-danger', 'Password && Confirm Password were not matched !!');
    			}else{
			        //Set Field data according to table column
			        $data = array(
			        	'ip_address' => $ip_address,
			        	'password' => $confirm_password,
			            'created_date' => $created_date,
			        	'created_time' => $created_time,
			        );

			        //Query For Updating Data
			    	$query = DB::table('tbl_users')
			    	             ->where('id', $request->session()->get('id'))
			    	             ->update($data);
	        		
	        		//Check either data updated or not
			     	if($query){
			     		//Flash Success Message
			     		$request->session()->flash('alert-success', 'Account Credentials has been updated successfully');
			     	}else{
			     		//Flash Error Message
			     		$request->session()->flash('alert-danger', 'Something went wrong !!');
			     	}

			     	//Redirect 
			     	return redirect()->route('admin_profile_settings');
		     	}
	     	}elseif($request->input('btn') == 3){
	     		//Get All Inputs
	     		$ip_address = $request->ip();
				$image = $request->file('image');
				$created_date = date('Y-m-d');
	            $created_time = date('H:i:s');

	     		//Inputs Validation
		        $input_validations = $request->validate([
		        	'image' => 'nullable|mimes:jpeg,jpg,png',
	        	]);

	        	if(!empty($image)){
	        		//File Upload
	        		$img = time().'.'.$image->guessExtension();
                    $image_path = $image->move(public_path().'/assets/admin/images/profile_images/', $img);

                    //Set Field data according to table column
			        $data = array(
			        	'ip_address' => $ip_address,
			        	'image' => $img,
			            'created_date' => $created_date,
			        	'created_time' => $created_time,
			        );

			        //Query For Updating Data
			    	$query = DB::table('tbl_users')
			    	             ->where('id', $request->session()->get('id'))
			    	             ->update($data);
	        		
	        		//Check either data updated or not
			     	if($query){
			     		//Flash Success Message
			     		$request->session()->flash('alert-success', 'Profile Image has been updated successfully');
			     	}else{
			     		//Flash Error Message
			     		$request->session()->flash('alert-danger', 'Something went wrong !!');
			     	}

			     	//Redirect 
			     	return redirect()->route('admin_profile_settings');
	        	}else{
	        		//Flash Error Message
		     		$request->session()->flash('alert-danger', 'you have to choose image first for updating image !!');

		     		//Redirect 
			     	return redirect()->route('admin_profile_settings');
	        	}
	     	}elseif($request->input('btn') == 4){
	     		//Get All Inputs
	     		$ip_address = $request->ip();
				$facebook = $request->input('facebook');
				$twitter = $request->input('twitter');
				$googleplus = $request->input('googleplus');
				$created_date = date('Y-m-d');
	            $created_time = date('H:i:s');

	     		//Inputs Validation
		        $input_validations = $request->validate([
		        	'facebook' => 'nullable|unique:tbl_users_social_profile',
		        	'twitter' => 'nullable|unique:tbl_users_social_profile',
		        	'googleplus' => 'nullable|unique:tbl_users_social_profile',
	        	]);

	        	//Set Field data according to table column
		        $data = array(
		        	'ip_address' => $ip_address,
		        	'facebook' => $facebook,
		        	'twitter' => $twitter,
		        	'googleplus' => $googleplus,
		        );

		        //Query For Updating Data
		    	$query = DB::table('tbl_users_social_profile')
		    	             ->where('user_id', $request->session()->get('id'))
		    	             ->update($data);
        		
        		//Check either data updated or not
		     	if($query){
		     		//Flash Success Message
		     		$request->session()->flash('alert-success', 'Social Profiles has been updated successfully');
		     	}else{
		     		//Flash Error Message
		     		$request->session()->flash('alert-danger', 'Something went wrong !!');
		     	}

		     	//Redirect 
		     	return redirect()->route('admin_profile_settings');
	     	}else{
        		print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    		}
    	}else{
    		print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
    }
}