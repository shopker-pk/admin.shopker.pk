<?php
namespace App\Http\Controllers\Admin\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class StoreController extends Controller{
	function countries_list(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') <= 1)){
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
    	if(!empty($request->session()->has('id') && $request->session()->get('role') <= 1)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Manage Store Settings',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query for Getting Store Settings
	    	$query = DB::table('tbl_site_settings')
	    	             ->select('title', 'address', 'country_id', 'city_id', 'zip_code', 'phone_1', 'phone_2', 'email_1', 'email_2', 'shipping_mood', 'international_shipping_mood', 'per_kg_0', 'per_kg_1', 'half_kg_0', 'half_kg_1', 'additional_per_kg_0', 'additional_per_kg_1', 'tax_mood', 'header_image', 'footer_image', 'favicon_image', 'facebook', 'twitter', 'googleplus')
	    	             ->leftJoin('tbl_site_shipping_settings', 'tbl_site_shipping_settings.id', '=', 'tbl_site_settings.id')
	    	             ->leftJoin('tbl_site_tax_settings', 'tbl_site_tax_settings.id', '=', 'tbl_site_settings.id')
	    	             ->leftJoin('tbl_site_images', 'tbl_site_images.id', '=', 'tbl_site_settings.id')
	    	             ->leftJoin('tbl_site_social_links', 'tbl_site_social_links.id', '=', 'tbl_site_settings.id')
	    	             ->leftJoin('tbl_site_shipping_charges', 'tbl_site_shipping_charges.id', '=', 'tbl_site_settings.id')
	    	             ->where('tbl_site_settings.admin_id', $request->session()->get('id'))
	    	             ->where('tbl_site_settings.id', 1);
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
	        return view('admin.settings.store.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function update(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') <= 1)){
    		//Inputs Validation
	        $input_validations = $request->validate([
	            'title' => 'required',
	            'address' => 'required',
	            'country' => 'required',
	            'city' => 'required|numeric',
	            'zip_code' => 'required|numeric',
	            'phone_1' => 'required|min:11|max:13|unique:tbl_site_settings,admin_id,'.$request->session()->get('id'),
	            'phone_2' => 'nullable|min:11|max:13|unique:tbl_site_settings,admin_id,'.$request->session()->get('id'),
	            'email_1' => 'required|email|unique:tbl_site_settings,id,'.$request->session()->get('id'),
	            'email_2' => 'nullable|email|unique:tbl_site_settings,id,'.$request->session()->get('id'),
	            'shipping_mood' => 'required|numeric',
	        	'international_shipping_mood' => 'required|numeric',
	        	'tax_mood' => 'required|numeric',
	        	'facebook' => 'nullable',
	        	'twitter' => 'nullable',
	        	'googleplus' => 'nullable',
	        	'header_image' => 'nullable|mimes:jpeg,jpg,png|max:2000',
	        	'footer_image' => 'nullable|mimes:jpeg,jpg,png|max:2000',
	        	'favicon_image' => 'nullable|mimes:jpeg,jpg,png|max:2000',
	        	'per_kg_0' => 'required|numeric',
	        	'per_kg_1' => 'required|numeric',
	        	'half_kg_0' => 'required|numeric',
	        	'half_kg_1' => 'required|numeric',
	        	'additional_per_kg_0' => 'required|numeric',
	        	'additional_per_kg_1' => 'required|numeric',
	        ]);

	        //Set Field data according to table column
	        $data = array(
	        	'admin_id' => $request->session()->get('id'),
	        	'ip_address' => $request->ip(),
	            'title' => $request->input('title'),
	        	'address' => $request->input('address'),
	        	'country_id' => $request->input('country'),
	            'city_id' => $request->input('city'),
	            'zip_code' => $request->input('zip_code'),
	            'phone_1' => $request->input('phone_1'),
	            'phone_2' => $request->input('phone_2'),
	            'email_1' => $request->input('email_1'),
	            'email_2' => $request->input('email_2'),
	            'created_date' => date('Y-m-d'),
	        	'created_time' => date('h:i:s'),
	        );
	        
	        //Query For Updating Data
	    	$site_settings = DB::table('tbl_site_settings')
	    	             ->where('id', 1)
	    	             ->update($data);
    		
    		//Set Field data according to table column
	        $data = array(
	        	'admin_id' => $request->session()->get('id'),
	        	'ip_address' => $request->ip(),
	        	'shipping_mood' => $request->input('shipping_mood'),
	        	'international_shipping_mood' => $request->input('international_shipping_mood'),
	        	'created_date' => date('Y-m-d'),
	        	'created_time' => date('h:i:s'),
        	);

        	//Query For Updating Data
	    	$shipping_settings = DB::table('tbl_site_shipping_settings')
	    	                         ->where('id', 1)
	    	                         ->update($data);

         	//Set Field data according to table column
	        $data = array(
	        	'admin_id' => $request->session()->get('id'),
	        	'ip_address' => $request->ip(),
	        	'per_kg_0' => $request->input('per_kg_0'),
	        	'per_kg_1' => $request->input('per_kg_1'),
	        	'half_kg_0' => $request->input('half_kg_0'),
	        	'half_kg_1' => $request->input('half_kg_1'),
	        	'additional_per_kg_0' => $request->input('additional_per_kg_0'),
	        	'additional_per_kg_1' => $request->input('additional_per_kg_1'),
	        	'created_date' => date('Y-m-d'),
	        	'created_time' => date('h:i:s'),
        	);

        	//Query For Updating Data
	    	$shipping_charges_settings = DB::table('tbl_site_shipping_charges')
	    	                                 ->where('id', 1)
	    	                                 ->update($data);

         	//Set Field data according to table column
	        $data = array(
	        	'admin_id' => $request->session()->get('id'),
	        	'ip_address' => $request->ip(),
	        	'tax_mood' => $request->input('tax_mood'),
	        	'created_date' => date('Y-m-d'),
	        	'created_time' => date('h:i:s'),
        	);

        	//Query For Updating Data
	    	$tax_settings = DB::table('tbl_site_tax_settings')
	    	                    ->where('id', 1)
	    	                    ->update($data);

        	//Set Field data according to table column
	        $data = array(
	        	'admin_id' => $request->session()->get('id'),
	        	'ip_address' => $request->ip(),
	        	'facebook' => $request->input('facebook'),
	        	'twitter' => $request->input('twitter'),
	        	'googleplus' => $request->input('googleplus'),
	        	'created_date' => date('Y-m-d'),
	        	'created_time' => date('h:i:s'),
	        );

	        //Query For Updating Data
	    	$query = DB::table('tbl_site_social_links')
	    	             ->where('id', 1)
	    	             ->update($data);

            //header logo
	        if(!empty($request->file('header_image'))){
	        	//Upload Image
		        $image = uniqid().'.'.$request->file('header_image')->guessExtension();
		        $image_path = $request->file('header_image')->move(public_path().'/assets/admin/images/settings/logo/', $image);

		        //Set Field data according to table column
		        $data = array(
		        	'admin_id' => $request->session()->get('id'),
	        		'ip_address' => $request->ip(),
		        	'header_image' => $image,
		        	'created_date' => date('Y-m-d'),
	        		'created_time' => date('h:i:s'),
	        	);

		        //Query For Updating Data
		    	$header_image = DB::table('tbl_site_images')
		    	             ->where('id', 1)
		    	             ->update($data);
	        }

	        //footer lgo
	        if(!empty($request->file('footer_image'))){
	        	//Upload Image
		        $image = uniqid().'.'.$request->file('footer_image')->guessExtension();
		        $image_path = $request->file('footer_image')->move(public_path().'/assets/admin/images/settings/logo/', $image);

		        //Set Field data according to table column
		        $data = array(
		        	'admin_id' => $request->session()->get('id'),
	        		'ip_address' => $request->ip(),
		        	'footer_image' => $image,
		        	'created_date' => date('Y-m-d'),
	        		'created_time' => date('h:i:s'),
	        	);

		        //Query For Updating Data
		    	$query = DB::table('tbl_site_images')
		    	             ->where('id', 1)
		    	             ->update($data);
	        }

	        //favicon image
	        if(!empty($request->file('favicon_image'))){
	        	//Upload Image
		        $image = uniqid().'.'.$$request->file('favicon_image')->guessExtension();
		        $image_path = $$request->file('favicon_image')->move(public_path().'/assets/admin/images/settings/logo/', $image);

		        //Set Field data according to table column
		        $data = array(
		        	'admin_id' => $request->session()->get('id'),
	        		'ip_address' => $request->ip(),
		        	'favicon_image' => $image,
		        	'created_date' => date('Y-m-d'),
	        		'created_time' => date('h:i:s'),
	        	);

		        //Query For Updating Data
		    	$query = DB::table('tbl_site_images')
		    	             ->where('id', 1)
		    	             ->update($data);
	        }
	        
	        if(!empty($site_settings == 1)){
	        	//Flash Error Message
	     		$request->session()->flash('alert-success', 'Settings has been updated successfully');

	     		return redirect()->back();
	        }else{
	        	//Flash Error Message
	     		$request->session()->flash('alert-danger', "Something wen't wrong !!");
	    		
	    		return redirect()->back()->withInput($request->all());
	    	}
		}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }
}