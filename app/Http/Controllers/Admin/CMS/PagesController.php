<?php
namespace App\Http\Controllers\Admin\CMS;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class PagesController extends Controller{
    function index(Request $request){
		if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Manage Pages',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query For Getting Data
	        $query = DB::table('tbl_pages')
	        			 ->select('*')
	        			 ->orderBy('id', 'DESC');
		 	$result['query'] = $query->paginate(10);
     		$result['total_records'] = $query->count();

	        //call page
	        return view('admin.cms.pages.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
	}

    function add(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
	    	//Header Data
	    	$result = array(
	            'page_title' => 'Add Pages',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	        //call page
	        return view('admin.cms.pages.add', $result); 
	    }else{
	    	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
    }

    function insert(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
	    	//Inputs Validation
	        $input_validations = $request->validate([
	            'title' => 'required|unique:tbl_pages',
	            'content' => 'nullable',
	            'meta_keywords' => 'nullable',
	            'meta_description' => 'nullable',
	            'status' => 'required|numeric',
	        ]);

     		
     		//Set Field data according to table column
	        $data = array(
	        	'user_id' => $request->session()->get('id'),
	        	'ip_address' => $request->ip(),
	        	'title' => $request->input('title'),
	        	'slug' => strtolower(str_replace(' ', '-', $request->input('title'))),
	            'content' => $request->input('content'),
	            'status' => $request->input('status'),
	            'created_date' => date('Y-m-d'),
	        	'created_time' => date('H:i:s'),
	        );

	        //Query For Inserting Data
	    	$page_id = DB::table('tbl_pages')
	    	               ->insertGetId($data);

         	//Set Field data according to table column
	        $data = array(
	        	'user_id' => $request->session()->get('id'),
	        	'ip_address' => $request->ip(),
	        	'page_id' => $page_id,
	        	'meta_keywords' => $request->input('meta_keywords'),
	            'meta_description' => $request->input('meta_description'),
	            'created_date' => date('Y-m-d'),
	        	'created_time' => date('H:i:s'),
	        );

	        //Query For Inserting Data
	    	$query = DB::table('tbl_pages_meta_details')
	    	             ->insertGetId($data);

	     	//Check either data inserted or not
	     	if(!empty($query && $page_id)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Page has been added successfully');

	     		//Redirect
            	return redirect()->back();
	     	}else{
	     		//Query For Deleting last insert Page
	     		$query = DB::table('tbl_pages')
	     		             ->where('id', $page_id)
	     		             ->delete();

	     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'Something went wrong !!');

	     		//Redirect
            	return redirect()->back()->withInput($request->all());
	     	}
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }

    function edit(Request $request, $id){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
	    	//Header Data
	    	$result = array(
	            'page_title' => 'Edit Pages',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query For Getting Data
	        $query = DB::table('tbl_pages')
	        			 ->select('tbl_pages.id', 'tbl_pages.title', 'tbl_pages.content', 'tbl_pages.status', 'tbl_pages_meta_details.meta_keywords', 'tbl_pages_meta_details.meta_description')
	        			 ->leftJoin('tbl_pages_meta_details', 'tbl_pages_meta_details.page_id', '=', 'tbl_pages.id')
	        			 ->where('tbl_pages.id', $id);
		 	$result['query'] = $query->first();

		 	if(!empty($result['query'])){
		 		//call page
	        	return view('admin.cms.pages.edit', $result); 
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
	            'title' => 'required|unique:tbl_pages,id,'.$id,
	            'content' => 'nullable',
	            'meta_keywords' => 'nullable',
	            'meta_description' => 'nullable',
	            'status' => 'required|numeric',
	        ]);

     		
     		//Set Field data according to table column
	        $data = array(
	        	'user_id' => $request->session()->get('id'),
	        	'ip_address' => $request->ip(),
	        	'title' => $request->input('title'),
	        	'slug' => strtolower(str_replace(' ', '-', $request->input('title'))),
	            'content' => $request->input('content'),
	            'status' => $request->input('status'),
	            'created_date' => date('Y-m-d'),
	        	'created_time' => date('H:i:s'),
	        );

	        //Query For Inserting Data
	    	$page_id = DB::table('tbl_pages')
	    	             ->where('id', $id)
	    	             ->update($data);

         	//Set Field data according to table column
	        $data = array(
	        	'user_id' => $request->session()->get('id'),
	        	'ip_address' => $request->ip(),
	        	'page_id' => $id,
	        	'meta_keywords' => $request->input('meta_keywords'),
	            'meta_description' => $request->input('meta_description'),
	            'created_date' => date('Y-m-d'),
	        	'created_time' => date('H:i:s'),
	        );

	        //Query For Inserting Data
	    	$query = DB::table('tbl_pages_meta_details')
	    	             ->where('page_id', $id)
	    	             ->update($data);

	     	//Check either data inserted or not
	     	if(!empty($query == 1)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Page has been updated successfully');
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
    		//Query For Deleting Data
    		$query = DB::table('tbl_pages')
    		             ->where('id', $id)
    		             ->delete();

         	//Check either data deleted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Page has been deleted successfully');
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
			$query = DB::table('tbl_pages')
	        			 ->select('*');
	        			 if(!empty($request->input('name'))){
	        	   $query->where('title', 'Like', '%'.$request->input('name').'%');
	        			 }
        			 	 if(!empty($request->input('status') != 2)){
	        	   $query->where('status', $request->input('status'));
	        			 }
	        	   $query->orderBy('id', 'DESC');
		 	$result['query'] = $query->paginate(10);
     		$result['total_records'] = $query->count();

	        //call page
	 		return view('admin.cms.pages.manage', $result); 
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

            $query = DB::table('tbl_pages')
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
}