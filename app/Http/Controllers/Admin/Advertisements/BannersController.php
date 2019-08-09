<?php
namespace App\Http\Controllers\Admin\Advertisements;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use File;

class BannersController extends Controller{
	function index(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') <= 1)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Manage Banner Advertisements',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query For Getting Data
	        $query = DB::table('tbl_banner_advertisements')
	        			 ->select('tbl_banner_advertisements.id as b_id', 'tbl_banner_advertisements.page_id', 'type', 'tbl_banner_advertisements.image', 'tbl_banner_advertisements.start_date', 'tbl_banner_advertisements.end_date', 'tbl_banner_advertisements.status', 'tbl_pages.title')
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
	    if(!empty($request->session()->has('id') && $request->session()->get('role') <= 1)){
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
		if(!empty($request->session()->has('id') && $request->session()->get('role') <= 1)){
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
		            'type' => $request->input('type'),
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
	    if(!empty($request->session()->has('id') && $request->session()->get('role') <= 1)){
	    	//Header Data
	    	$result = array(
	            'page_title' => 'Edit Banner',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

    		//Query For Getting Data
	        $query = DB::table('tbl_banner_advertisements')
	        			 ->select('*')
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

	function update(Request $request, $id){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
			//Inputs Validation
	        $input_validations = $request->validate([
	            'banner_url' => 'nullable',
	            'url' => 'nullable',
	            'page' => 'required',
	            'type' => 'required',
	            'start_date' => 'required',
	            'end_date' => 'required',
	            'status' => 'required',
	        ]);

	        if(!empty($request->file('url'))){
	        	//Upload Image
		        $featured_image = time().'.'.$request->file('url')->guessExtension();
		        $image_path = $request->file('url')->move(public_path().'/assets/admin/images/advertisements/banners/', $featured_image);
            	
            	//Set Field data according to table column
		        $data = array(
		        	'user_id' => $request->session()->get('id'),
		        	'ip_address' => $request->ip(),
		            'image' => $featured_image,
		            'page_id' => $request->input('page'),
		            'type' => $request->input('type'),
		            'url' => $request->input('banner_url'),
		        	'start_date' => date('Y-m-d', strtotime($request->input('start_date'))),
		        	'end_date' => date('Y-m-d', strtotime($request->input('end_date'))),
		            'status' => $request->input('status'),
		            'created_date' => date('Y-m-d'),
		        	'created_time' => date('H:i:s'),
		        );
            }else{
            	//Set Field data according to table column
		        $data = array(
		        	'user_id' => $request->session()->get('id'),
		        	'ip_address' => $request->ip(),
		            'page_id' => $request->input('page'),
		            'type' => $request->input('type'),
		            'url' => $request->input('banner_url'),
		        	'start_date' => date('Y-m-d', strtotime($request->input('start_date'))),
		        	'end_date' => date('Y-m-d', strtotime($request->input('end_date'))),
		            'status' => $request->input('status'),
		            'created_date' => date('Y-m-d'),
		        	'created_time' => date('H:i:s'),
		        );
            }
        
    		//Query For Inserting Data
	    	$query = DB::table('tbl_banner_advertisements')
	    	             ->where('id', $id)
	    	             ->update($data);	 

	        //Check either data inserted or not
	     	if(!empty($query == 1)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Banners has been added successfully');
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
	     	return redirect()->back();
        }else{
	    	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
    }

    function search(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') <= 1)){ 
    		//Necessary Page Data For header Page
	        $result = array(
	            'page_title' => 'Search Records',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        ); 

			//Query For Getting Search Data
			$query = DB::table('tbl_banner_advertisements')
	        			 ->select('tbl_banner_advertisements.id as b_id', 'tbl_banner_advertisements.page_id', 'type', 'tbl_banner_advertisements.image', 'tbl_banner_advertisements.start_date', 'tbl_banner_advertisements.end_date', 'tbl_banner_advertisements.status', 'tbl_pages.title')
	        			 ->LeftJoin('tbl_pages', 'tbl_pages.id', 'tbl_banner_advertisements.page_id');
	        			 if(!empty($request->input('from_date'))){
    			   $query->where('tbl_banner_advertisements.created_date', '>=', date('Y-m-d', strtotime($request->input('from_date'))));		
	        			 }
	        			 if(!empty($request->input('to_date'))){
        		   $query->where('tbl_banner_advertisements.created_date', '<=', date('Y-m-d', strtotime($request->input('to_date'))));
	        			 }
	        			 if(!empty($request->input('status'))){
	        	   $query->where('tbl_banner_advertisements.status', $request->input('to_date'));
	        			 }
	        	   $query->orderBy('tbl_banner_advertisements.id', 'DESC');
		 	$result['query'] = $query->paginate(10);
     		$result['total_records'] = $query->count();

	        //call page
	 		return view('admin.advertisements.banners.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }
}