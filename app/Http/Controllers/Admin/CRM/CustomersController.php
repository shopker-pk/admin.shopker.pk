<?php
namespace App\Http\Controllers\Admin\CRM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class CustomersController extends Controller{
	function index(Request $request){
		if(!empty($request->session()->has('id')) && $request->session()->get('role') == 0){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Manage Customers',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query For Getting Data
	        $query = DB::table('tbl_users')
	        			 ->select('tbl_users.id', 'first_name', 'last_name', 'cnic', 'address', 'phone_no', 'email', 'image', 'status', 'tbl_cities.name as city_name', 'tbl_countries.country_name')
	        			 ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_users.country_id')
	        			 ->leftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_users.city_id')
	        			 ->where('tbl_users.role', 3)
	        			 ->orderBy('tbl_users.id', 'DESC');
		 	$result['query'] = $query->paginate(10);
     		$result['total_records'] = $result['query']->count();

     		//call page
	        return view('admin.crm.customers.manage', $result); 
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

    function update(Request $request, $id){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
    		//Set Field data according to table column
	        $data = array(
	        	'status' => $request->input('status'),
        	);

			//Query For Updating User Status
			$query = DB::table('tbl_users')
			             ->where('id', $id)
			             ->update($data);

         	//Check either data updated or not
	     	if(!empty($query == 1)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Customer Status has been updated successfully');
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

	    	//Query For Getting Search Data
			$query = DB::table('tbl_users')
	                     ->select('tbl_users.id', 'first_name', 'last_name', 'cnic', 'address', 'phone_no', 'email', 'image', 'status', 'tbl_cities.name as city_name', 'tbl_countries.country_name')
	        			 ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_users.country_id')
	        			 ->leftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_users.city_id');
	        			 if(!empty($request->input('name'))){
	  			 $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'Like', '%'.$request->input('name').'%');
	        			 }
	        			 if(!empty($request->input('email'))){
	        	  $query->where('email', 'Like', '%'.$request->input('email').'%');
	        			 }
	        			 if(!empty($request->input('status'))){
	        	  $query->where('status', $request->input('status'));
	        			 } 
	              $query->where('tbl_users.role', 3)
	                    ->orderBy('tbl_users.id', 'DESC');
	        $result['query'] = $query->paginate(10);
     		$result['total_records'] = $query->count();

	        //call page
	        return view('admin.crm.customers.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }
}