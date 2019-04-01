<?php
namespace App\Http\Controllers\Admin\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class StoreController extends Controller{
	function countries_list(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
			//Query For Getting Countries
	 		$query = DB::table('tbl_countries')
	    	             ->select('*');
	 		$result = $query->get();

	 		//initializing Generate data variables
	        $ajax_response_data = array(
	            'ERROR' => 'FALSE',
	            'DATA' => '',
	        );

	        $html = '';
	        if(!empty($result)){
	        	$html .= '<label class="label-control">Country</label><select id="country" name="country" class="form-control" style="width: 100%"><option>No Country Selected</option>';
	        	foreach($result as $row){
	        		$html .= '<option value='.$row->country_code.'>'.$row->country_name.'</option>';
	        	}
	        	$html .= '</select>';
	        	$ajax_response_data['ERROR'] = 'FALSE';
	            $ajax_response_data['DATA'] = $html;
	            echo json_encode($ajax_response_data);
	        }else{
	        	$html .= '<label class="label-control">Country</label><select id="country" name="country" class="form-control" style="width: 100%"><option>No Country found !!</option></select>';
	            $ajax_response_data['ERROR'] = 'TRUE';
	            $ajax_response_data['DATA'] = $html;
	            echo json_encode($ajax_response_data);
	        }
	        die;
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

    function edit(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Manage Store Settings',
	            'meta_keywords' => 'manage_store_settings',
	            'meta_description' => 'manage_store_settings',
	        );

	    	//Query For Getting Country codes
	 		$query = DB::table('tbl_countries_phone_code')
	    	             ->select('*');
	 		$result['country_code'] = $query->get();

	 		//Query for Getting Countries
	    	$query = DB::table('tbl_countries')
	    	             ->select('id', 'country_code', 'country_name')
	    	             ->orderBy('id', 'DESC');
     		$result['countries'] = $query->get();
			
			//Query for Getting Store Settings
	    	$query = DB::table('tbl_site_settings')
	    	             ->select('*')
	    	             ->where('admin_id', $request->session()->get('id'));
     		$result['query'] = $query->first();

			if(!empty($result['query'])){
				//Query for Getting Cities
		    	$query = DB::table('tbl_cities')
		    	             ->select('id', 'country_id', 'name')
		    	             ->where('country_id', $result['query']->country_id)
		    	             ->orderBy('id', 'DESC');
	     		$result['cities'] = $query->get();
	     	}
	 		
	 		//Query For Getting Shipping Settings
	 		$query = DB::table('tbl_site_shipping_settings')
	 		             ->select('*')
	 		             ->where('admin_id', $request->session()->get('id'));
         	$result['shipping_settings'] = $query->first();

         	//Query For Getting Tax Settings
	 		$query = DB::table('tbl_site_tax_settings')
	 		             ->select('*')
	 		             ->where('admin_id', $request->session()->get('id'));
         	$result['tax_setting'] = $query->first();

         	//Query For Getting Images Settings
	 		$query = DB::table('tbl_site_images')
	 		             ->select('*')
	 		             ->where('admin_id', $request->session()->get('id'));
         	$result['images_setting'] = $query->first();

         	//Query for Getting Social Links
	    	$query = DB::table('tbl_site_social_links')
	    	             ->select('facebook', 'twitter', 'googleplus')
	    	             ->where('admin_id', $request->session()->get('id'));
     		$result['social_links'] = $query->first();
     				
			//call page
	        return view('admin.settings.store.edit', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function update(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
    		if($request->input('btn') == 0){
	    		//Get All Inputs
	        	$user_id = $request->session()->get('id');
	        	$ip_address = $request->ip();
	            $owner_name = $request->input('owner_name');
	        	$store_name = $request->input('store_name');
	            $store_address = $request->input('store_address');
	            $country = $request->input('country');
	            $city = $request->input('city');
	            $zip = $request->input('zip');
	            $country_code_1 = $request->input('code_1');
	            $phone_1 = $request->input('phone_1');
	            $country_code_2 = $request->input('code_2');
	            $phone_2 = $request->input('phone_2');
	            $email_1 = $request->input('email_1');
	            $email_2 = $request->input('email_2');
	            $created_date = date('Y-m-d');
	            $created_time = date('H:i:s');

	            //Inputs Validation
		        $input_validations = $request->validate([
		            'owner_name' => 'nullable|unique:tbl_store_settings,user_id,'.$request->session()->get('id'),
		            'store_name' => 'nullable',
		            'store_address' => 'nullable|unique:tbl_store_settings,user_id,'.$request->session()->get('id'),
		            'country' => 'nullable',
		            'city' => 'nullable',
		            'zip' => 'nullable',
		            'code_1' => 'nullable',
		            'phone_1' => 'nullable|min:10|max:10|unique:tbl_store_settings,user_id,'.$request->session()->get('id'),
		            'code_2' => 'nullable',
		            'phone_2' => 'nullable|min:10|max:10|unique:tbl_store_settings,user_id,'.$request->session()->get('id'),
		            'email_1' => 'nullable|email|unique:tbl_store_settings,user_id,'.$request->session()->get('id'),
		            'email_2' => 'nullable|email|unique:tbl_store_settings,user_id,'.$request->session()->get('id'),
		        ]);

		        //Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		            'owner_name' => $owner_name,
		        	'store_name' => $store_name,
		        	'store_address' => $store_address,
		            'country_id' => $country,
		            'city_id' => $city,
		            'zip_code' => $zip,
		            'country_code_1' => $country_code_1,
		            'cell_number1' => $phone_1,
		            'country_code_2' => $country_code_2,
		            'cell_number2' => $phone_2,
		            'email1' => $email_1,
		            'email2' => $email_2,
		            'created_date' => $created_date,
		        	'created_time' => $created_time,
		        );
		        
		        //Query For Updating Data
		    	$query = DB::table('tbl_store_settings')
		    	             ->where('user_id', $request->session()->get('id'))
		    	             ->update($data);
        		
        		//Check either data updated or not
		     	if(!empty($query)){
		     		//Flash Success Message
		     		$request->session()->flash('alert-success', 'Store Settings has been updated successfully');
		     	}else{
		     		//Flash Error Message
		     		$request->session()->flash('alert-danger', 'Something went wrong !!');
		     	}
	    		
	    		//Redirect 
		     	return redirect()->route('edit_store_setting');
         	}elseif($request->input('btn') == 1){
         		//Get All Inputs
	        	$user_id = $request->session()->get('id');
	        	$ip_address = $request->ip();
	            $shipping_mood = $request->input('shipping_mood', '1');
	            $international_shipping_mood = $request->input('international_shipping_mood', '1');
				$created_date = date('Y-m-d');
	            $created_time = date('H:i:s');

	            //Inputs Validation
		        $input_validations = $request->validate([
		        	'shipping_mood' => 'nullable',
		        	'international_shipping_mood' => 'nullable',
	        	]);

	        	//Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		        	'shipping_mood' => $shipping_mood,
		        	'international_shipping_mood' => $international_shipping_mood,
		        	'created_date' => $created_date,
		        	'created_time' => $created_time,
	        	);

	        	//Query For Updating Data
		    	$query = DB::table('tbl_shipping_settings')
		    	             ->where('user_id', $request->session()->get('id'))
		    	             ->update($data);
        		
        		//Check either data updated or not
		     	if(!empty($query)){
		     		//Flash Success Message
		     		$request->session()->flash('alert-success', 'Store Shipping Settings has been updated successfully');
		     	}else{
		     		//Flash Error Message
		     		$request->session()->flash('alert-danger', 'Something went wrong !!');
		     	}

		     	//Redirect 
		     	return redirect()->route('edit_store_setting');
         	}elseif($request->input('btn') == 2){
         		//Get All Inputs
	        	$user_id = $request->session()->get('id');
	        	$ip_address = $request->ip();
	            $tax_mood = $request->input('tax_mood', '1');
				$created_date = date('Y-m-d');
	            $created_time = date('H:i:s');

	            //Inputs Validation
		        $input_validations = $request->validate([
		        	'tax_mood' => 'nullable',
	        	]);

	        	//Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		        	'tax_mood' => $tax_mood,
		        	'created_date' => $created_date,
		        	'created_time' => $created_time,
	        	);

	        	//Query For Updating Data
		    	$query = DB::table('tbl_tax_settings')
		    	             ->where('user_id', $request->session()->get('id'))
		    	             ->update($data);
        		
        		//Check either data updated or not
		     	if(!empty($query)){
		     		//Flash Success Message
		     		$request->session()->flash('alert-success', 'Store Tax Setting has been updated successfully');
		     	}else{
		     		//Flash Error Message
		     		$request->session()->flash('alert-danger', 'Something went wrong !!');
		     	}

		     	//Redirect 
		     	return redirect()->route('edit_store_setting');
         	}elseif($request->input('btn') == 3){
         		//Get All Inputs
	        	$user_id = $request->session()->get('id');
	        	$ip_address = $request->ip();
	            $header_image = $request->file('header_image');
	            $footer_image = $request->file('footer_image');
	            $favicon_image = $request->file('favicon_image');
				$created_date = date('Y-m-d');
	            $created_time = date('H:i:s');

	            //Inputs Validation
		        $input_validations = $request->validate([
		        	'header_image' => 'nullable|mimes:jpeg,jpg,png|max:2000|',
		        	'footer_image' => 'nullable|mimes:jpeg,jpg,png|max:2000|',
		        	'favicon_image' => 'nullable|mimes:jpeg,jpg,png|max:2000|',
	        	]);

		        //header logo
		        if(!empty($header_image)){
		        	//Upload Image
			        $img = uniqid().'.'.$header_image->guessExtension();
			        $image_path = $header_image->move(public_path().'/assets/admin/images/settings/logo/', $img);

			        //Set Field data according to table column
			        $data = array(
			        	'user_id' => $user_id,
			        	'ip_address' => $ip_address,
			        	'header_image' => $img,
			        	'created_date' => $created_date,
			        	'created_time' => $created_time,
		        	);

			        //Query For Updating Data
			    	$query = DB::table('tbl_store_images')
			    	             ->where('user_id', $request->session()->get('id'))
			    	             ->update($data);
		        
	             	//Check either data updated or not
			     	if(!empty($query)){
			     		//Flash Success Message
			     		$request->session()->flash('alert-success', 'Store Images has been updated successfully');
			     	}else{
			     		//Flash Error Message
			     		$request->session()->flash('alert-danger', 'Something went wrong !!');
			     	}
		        }

		        //footer lgo
		        if(!empty($footer_image)){
		        	//Upload Image
			        $img = uniqid().'.'.$footer_image->guessExtension();
			        $image_path = $footer_image->move(public_path().'/assets/admin/images/settings/logo/', $img);

			        //Set Field data according to table column
			        $data = array(
			        	'user_id' => $user_id,
			        	'ip_address' => $ip_address,
			        	'footer_image' => $img,
			        	'created_date' => $created_date,
			        	'created_time' => $created_time,
		        	);

			        //Query For Updating Data
			    	$query = DB::table('tbl_store_images')
			    	             ->where('user_id', $request->session()->get('id'))
			    	             ->update($data);
		        	
		        	//Check either data updated or not
			     	if(!empty($query)){
			     		//Flash Success Message
			     		$request->session()->flash('alert-success', 'Store Images has been updated successfully');
			     	}else{
			     		//Flash Error Message
			     		$request->session()->flash('alert-danger', 'Something went wrong !!');
			     	}
		        }

		        //favicon image
		        if(!empty($favicon_image)){
		        	//Upload Image
			        $img = uniqid().'.'.$favicon_image->guessExtension();
			        $image_path = $favicon_image->move(public_path().'/assets/admin/images/settings/logo/', $img);

			        //Set Field data according to table column
			        $data = array(
			        	'user_id' => $user_id,
			        	'ip_address' => $ip_address,
			        	'favicon_image' => $img,
			        	'created_date' => $created_date,
			        	'created_time' => $created_time,
		        	);

			        //Query For Updating Data
			    	$query = DB::table('tbl_store_images')
			    	             ->where('user_id', $request->session()->get('id'))
			    	             ->update($data);

	             	//Check either data updated or not
			     	if(!empty($query)){
			     		//Flash Success Message
			     		$request->session()->flash('alert-success', 'Store Images has been updated successfully');
			     	}else{
			     		//Flash Error Message
			     		$request->session()->flash('alert-danger', 'Something went wrong !!');
			     	}
		        }
		        
		        if(empty($request)){
		        	//Flash Error Message
		     		$request->session()->flash('alert-danger', 'Select Image first before click on update button !!');
		        }
        		
        		//Redirect 
		     	return redirect()->route('edit_store_setting');
         	}elseif($request->input('btn') == 4){
				//Get All Inputs
	        	$user_id = $request->session()->get('id');
	        	$ip_address = $request->ip();
	            $map = $request->input('map');
				$created_date = date('Y-m-d');
	            $created_time = date('H:i:s');

	            //Inputs Validation
		        $input_validations = $request->validate([
		        	'map' => 'nullable',
		        ]);

		        //Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		        	'map' => $map,
		        	'created_date' => $created_date,
		        	'created_time' => $created_time,
	        	);

		        //Query For Updating Data
		    	$query = DB::table('tbl_store_map')
		    	             ->where('user_id', $request->session()->get('id'))
		    	             ->update($data);

	         	//Check either data updated or not
		     	if(!empty($query)){
		     		//Flash Success Message
		     		$request->session()->flash('alert-success', 'Map Setting has been updated successfully');
		     	}else{
		     		//Flash Error Message
		     		$request->session()->flash('alert-danger', 'Something went wrong !!');
		     	}

		     	//Redirect 
		     	return redirect()->route('edit_store_setting');
	     	}elseif($request->input('btn') == 5){
	     		//Get All Inputs
	     		$user_id = $request->session()->get('id');
	     		$ip_address = $request->ip();
				$facebook = $request->input('facebook');
				$twitter = $request->input('twitter');
				$googleplus = $request->input('googleplus');
				$created_date = date('Y-m-d');
	            $created_time = date('H:i:s');

	     		//Inputs Validation
		        $input_validations = $request->validate([
		        	'facebook' => 'nullable|unique:tbl_store_social_links,user_id,'.$request->session()->get('id'),
		        	'twitter' => 'nullable|unique:tbl_store_social_links,user_id,'.$request->session()->get('id'),
		        	'googleplus' => 'nullable|unique:tbl_store_social_links,user_id,'.$request->session()->get('id'),
	        	]);

	        	//Set Field data according to table column
		        $data = array(
		        	'user_id' => $user_id,
		        	'ip_address' => $ip_address,
		        	'facebook' => $facebook,
		        	'twitter' => $twitter,
		        	'googleplus' => $googleplus,
		        );

		        //Query For Updating Data
		    	$query = DB::table('tbl_store_social_links')
		    	             ->where('user_id', $request->session()->get('id'))
		    	             ->update($data);
        		
        		//Check either data updated or not
		     	if(!empty($query)){
		     		//Flash Success Message
		     		$request->session()->flash('alert-success', 'Store Social Links has been updated successfully');
		     	}else{
		     		//Flash Error Message
		     		$request->session()->flash('alert-danger', 'Something went wrong !!');
		     	}

		     	//Redirect 
		     	return redirect()->route('edit_store_setting');
	     	}
		}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }
}