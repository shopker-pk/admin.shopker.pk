<?php
namespace App\Http\Controllers\Admin\Advertisements;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use File;

class BannersController extends Controller{
	function index(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Manage Banner Advertisements',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query For Getting Data
	        $query = DB::table('tbl_banner_advertisements')
	        			 ->select('tbl_banner_advertisements.id as b_id', 'tbl_banner_advertisements.page_id', 'tbl_banner_advertisements.image', 'tbl_banner_advertisements.start_date', 'tbl_banner_advertisements.end_date', 'tbl_banner_advertisements.status', 'tbl_pages.title')
	        			 ->leftJoin('tbl_pages', 'tbl_pages.id', '=', 'tbl_banner_advertisements.page_id')
	        			 ->orderBy('tbl_banner_advertisements.id', 'DESC');
		 	$result['query'] = $query->paginate(10);
     		$result['total_records'] = $result['query']->count();

	        //call page
	        return view('admin.advertisements.banners.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

	function add(Request $request){
	    if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
	    	//Header Data
	    	$result = array(
	            'page_title' => 'Add Banners',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	        //call page
	        return view('admin.advertisements.banners.add', $result); 
	    }else{
	    	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

	function insert(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
	        //Inputs Validation
	        $input_validations = $request->validate([
	            'banner_url.*' => 'nullable',
	            'url.*' => 'required',
	            'page' => 'required',
	            'type' => 'required',
	            'start_date' => 'required',
	            'end_date' => 'required',
	            'status' => 'required',
	        ]);

	        $count = 0;
	        foreach($request->input('url') as $row){
	        	//Upload Product Image
                $image = uniqid().'.jpeg';
                $image_path = file_put_contents(public_path().'/assets/admin/images/advertisements/banners/'.$image, file_get_contents($row));
	        
        		//Set Field data according to table column
		        $data = array(
		        	'user_id' => $request->session()->get('id'),
		        	'ip_address' => $request->ip(),
		            'image' => $image,
		            'page_id' => $request->input('page'),
		            'url' => $request->input('banner_url')[$count],
		        	'start_date' => date('Y-m-d', strtotime($request->input('start_date'))),
		        	'end_date' => date('Y-m-d', strtotime($request->input('end_date'))),
		            'status' => $request->input('status'),
		            'created_date' => date('Y-m-d'),
		        	'created_time' => date('H:i:s'),
		        );

		        $row++;
		        
		        //Query For Inserting Data
		    	$query = DB::table('tbl_banner_advertisements')
		    	             ->insertGetId($data);	 
	        }

	        //Check either data inserted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Banners has been added successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('add_banner_advertisements');
		}else{
	    	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

	function edit(Request $request, $id){
	    if(!empty($request->session()->has('id') && $request->session()->get('role') == 5)){
	    	//Header Data
	    	$result = array(
	            'page_title' => 'Edit Banners',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

    		//Query For Getting Data
	        $query = DB::table('tbl_banner_advertisements')
	        			 ->select('id', 'page_id', 'image', 'url', 'start_date', 'end_date', 'status')
	        			 ->where('id', $id);
		 	$result['query'] = $query->first();

		 	if(!empty($result['query'])){
		 		//call page
	        	return view('admin.advertisements.banners.edit', $result); 
		 	}else{
		 		print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		 	}
	   	}else{
	    	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
	}

	function delete_images(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 10 && $id)){
	        //initializing Generate data variables
	        $ajax_response_data = array(
	            'ERROR' => 'FALSE',
	            'DATA' => '',
	        );

	        $image = DB::table('tbl_banner_advertisements')
                             ->select('image')
                             ->where('id', $id);
            $result = $image->first();
            
            File::delete(public_path().'/assets/admin/images/advertisements/banners/'.$result->image);

	        //Query For Deleting Image 
	        $query = DB::table('tbl_banner_advertisements')
	                     ->where('id', $id)
	                     ->delete();

	        //check either image is deleted or not
	        if(!empty($query)){
	        	$ajax_response_data = array(
		            'ERROR' => 'FALSE',
		            'DATA' => 'Image has been deleted successfully',
		        );
	            echo json_encode($ajax_response_data);
	        }else{
	        	$ajax_response_data = array(
		            'ERROR' => 'TRUE',
		            'DATA' => "Something wen't wrong",
		        );
	            echo json_encode($ajax_response_data); 
	        }
	        die;
    	}else{
	    	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
    }

	function update(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 10 && $id)){
			//Get All Inputs
	    	$user_id = $request->session()->get('id');
	    	$ip_address = $request->ip();
	        $images = $request->file('images');
	    	$page = $request->input('page');
	    	$url = $request->input('url');
	        $start_date = date('Y-m-d', strtotime($request->input('start_date')));
	        $end_date = date('Y-m-d', strtotime($request->input('end_date')));
	        $status = $request->input('status');
	        $created_date = date('Y-m-d');
	        $created_time = date('H:i:s');

	        //Inputs Validation
	        $input_validations = $request->validate([
	            'images.*' => 'required|mimes:jpeg,jpg,png|max:2000|', //
	            'page' => 'required',
	            'url.*' => 'nullable',
	            'start_date' => 'required',
	            'end_date' => 'required',
	            'status' => 'required',
	        ]);

	        echo '<pre>'; print_r($request->all()); die;
	        if(!empty($images)){
	        	$row = 0;
       			//insert array
		        foreach($images as $img){
		        	//Upload Image
			        $image = uniqid().'.'.$img->guessExtension();
			        $image_path = $img->move(public_path().'/assets/admin/images/advertisements/banners/', $image);

	        		//Set Field data according to table column
			        $data = array(
			        	'user_id' => $user_id,
			        	'ip_address' => $ip_address,
			            'image' => $image,
			            'page_id' => $page,
			            'url' => $banner_url[$row],
			        	'start_date' => $start_date,
			        	'end_date' => $end_date,
			            'status' => $status,
			            'created_date' => $created_date,
			        	'created_time' => $created_time,
			        );
			        
			        $row++;
			        
			        $result[] = $data;
			        //Query For updated Data
			    	/*$query = DB::table('tbl_banner_advertisements')
			    	             ->insertGetId($data);*/
	        	} 	
	        	echo '<pre>'; print_r($result); die;
	        	//Query For Getting Images
			 	$query = DB::table('tbl_banner_advertisements')
		        			 ->select('id')
		        			 ->where('page_id', $id);
			 	$img_id = $query->get();

			 	$row = 0;
	        	foreach($img_id as $img){
	        		//Set Field data according to table column
			        $data = array(
			        	'user_id' => $user_id,
			        	'ip_address' => $ip_address,
			            'page_id' => $page,
			            'url' => $url[$row],
			        	'start_date' => $start_date,
			        	'end_date' => $end_date,
			            'status' => $status,
			            'created_date' => $created_date,
			        	'created_time' => $created_time,
			        );

			        $row ++;

			        //Query For updated Data
			    	$query = DB::table('tbl_banner_advertisements')
			    	             ->where('id', $img->id)
			    	             ->update($data);
             	}
	        }else{
	        	//Query For Getting Images
			 	$query = DB::table('tbl_banner_advertisements')
		        			 ->select('id')
		        			 ->where('page_id', $id);
			 	$img_id = $query->get();

			 	$row = 0;
	        	foreach($img_id as $img){
	        		//Set Field data according to table column
			        $data = array(
			        	'user_id' => $user_id,
			        	'ip_address' => $ip_address,
			            'page_id' => $page,
			            'url' => $url[$row],
			        	'start_date' => $start_date,
			        	'end_date' => $end_date,
			            'status' => $status,
			            'created_date' => $created_date,
			        	'created_time' => $created_time,
			        );

			        $row ++;

			        //Query For updated Data
			    	$query = DB::table('tbl_banner_advertisements')
			    	             ->where('id', $img->id)
			    	             ->update($data);
             	}
             	//echo '<pre>'; print_r($data); die;
	        }

	        //Check either data updated or not
	     	if(!empty($query == 1)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Banners has been updated successfully');
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

	function delete(Request $request, $id){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){

        	$image = DB::table('tbl_banner_advertisements')
                             ->select('image')
                             ->where('id', $id);
            $result = $image->first();
            
            File::delete(public_path().'/assets/admin/images/advertisements/banners/'.$result->image);

	        //Query For Deleting Image 
	        $query = DB::table('tbl_banner_advertisements')
	                     ->where('id', $id)
	                     ->delete();

	     	//Check either data deleted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Banners has been deleted successfully');
	     	}else{
	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');
	     	}

	     	//Redirect 
	     	return redirect()->route('manage_banner_advertisements');
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

			//Get All Inputs
			$name = $request->input('name');
			$status = $request->input('status');

			//Query For Getting Search Data
			$query = DB::table('tbl_banner_advertisements')
	        			 ->select('tbl_banner_advertisements.id as b_id', 'tbl_banner_advertisements.page_id', 'tbl_banner_advertisements.start_date', 'tbl_banner_advertisements.end_date', 'tbl_banner_advertisements.status', 'tbl_pages.id as p_id', 'tbl_pages.title', 'tbl_pages.status as p_status')
	        			 ->LeftJoin('tbl_pages', 'tbl_pages.id', 'tbl_banner_advertisements.page_id')
	        			 ->where('tbl_pages.title', 'Like', '%'. $name .'%')
	                     ->where('tbl_pages.status', $status)
	        			 ->orderBy('tbl_banner_advertisements.id', 'DESC');
		 	$result['query'] = $query->paginate(10);
     		$result['total_records'] = $query->count();

	        //call page
	 		return view('admin.advertisements.banners.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }
}