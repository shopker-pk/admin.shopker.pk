<?php
namespace App\Http\Controllers\Admin\CRM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class VendorsController extends Controller{
	function index(Request $request){
		if(!empty($request->session()->has('id')) && $request->session()->get('role') == 0){
        	//Header Data
	    	$result = array(
	            'page_title' => 'Manage Vendors',
	            'meta_keywords' => '',
	            'meta_description' => '',
	        );

	    	//Query For Getting Vendors
	        $query = DB::table('tbl_users')
	        			 ->select('tbl_users.id', 'first_name', 'last_name', 'address', 'phone_no', 'email', 'image', 'status', 'tbl_cities.name as city_name', 'tbl_countries.country_name')
	        			 ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_users.country_id')
	        			 ->leftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_users.city_id')
	        			 ->where('tbl_users.role', 2)
	        			 ->orderBy('tbl_users.id', 'DESC');
		 	$result['query'] = $query->paginate(10);
     		$result['total_records'] = $result['query']->count();

     		foreach($result['query'] as $row){
     			//Query For Getting Vendors Commission Details if exist
	     		$query = DB::table('tbl_vendors_commission')
	     		             ->select('tbl_vendors_commission.id', 'vendor_id', 'type', 'total_percent', 'category_id')
	     		             ->leftJoin('tbl_parent_categories', 'tbl_parent_categories.id', '=', 'tbl_vendors_commission.category_id')
	     		             ->where('vendor_id', $row->id)
	     		             ->orderBy('tbl_vendors_commission.id', 'DESC');
	         	$result['commission'][$row->id] = $query->get();
     		}

     		//Query For Getting Parent Categories
     		$query = DB::table('tbl_parent_categories')
     		             ->select('id', 'name')
     		             ->where('status', 0)
     		             ->orderBy('sorting_order', 'ASC');
         	$result['categories'] = $query->get();
     		//dd($result['commission']);
     		//call page
	        return view('admin.crm.vendors.manage', $result); 
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
	     		$request->session()->flash('alert-success', 'Vendor Status has been updated successfully');
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

    function add_commission(Request $request, $id){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0 && $id)){
    		//Inputs Validation
	        $input_validations = $request->validate([
	            'category.*' => 'nullable|numeric',
	            'total.*' => 'nullable',
	            'total_commission' => 'nullable',
	        ]);

	        //Query For Deleting All Previous Commisions
	        $query = DB::table('tbl_vendors_commission')
	                     ->where('vendor_id', $id)
	                     ->delete();

	        if(!empty($request->input('commision_type') == 1)){
	        	$count = 0;
	     		foreach($request->input('category') as $row){
	     			//Set Field data according to table column
			        $data = array(
			        	'admin_id' => $request->session()->get('id'),
			        	'ip_address' => $request->ip(),
			        	'vendor_id' => $id,
			        	'type' => $request->input('commision_type'),
			        	'category_id' => $row,
			            'total_percent' => $request->input('total')[$count],
			            'created_date' => date('Y-m-d'),
			        	'created_time' => date('H:i:s'),
			        );	

			        $count++;

			        //Query For Inserting Data
			    	$query = DB::table('tbl_vendors_commission')
			    	             ->insertGetId($data);
				}
	        }else{
	        	//Set Field data according to table column
		        $data = array(
		        	'admin_id' => $request->session()->get('id'),
		        	'ip_address' => $request->ip(),
		        	'vendor_id' => $id,
		        	'type' => $request->input('commision_type'),
		        	'category_id' => 0,
		            'total_percent' => $request->input('total_commission'),
		            'created_date' => date('Y-m-d'),
		        	'created_time' => date('H:i:s'),
		        );
				
				//Query For Inserting Data
		    	$query = DB::table('tbl_vendors_commission')
		    	             ->insertGetId($data);
			}

			//Check either data inserted or not
	     	if(!empty($query)){
	     		//Flash Success Message
	     		$request->session()->flash('alert-success', 'Commission has been updated successfully');

	     		//Redirect
            	return redirect()->back();
	     	}else{
	     		//Query For Deleting last insert Page
	     		$query = DB::table('tbl_vendors_commission')
	     		             ->where('vendor_id', $id)
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
	              $query->where('tbl_users.role', 2)
	                    ->orderBy('tbl_users.id', 'DESC');
	        $result['query'] = $query->paginate(10);
     		$result['total_records'] = $query->count();

	        //call page
	        return view('admin.crm.vendors.manage', $result); 
        }else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function export(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Query For Getting Product
            $query = DB::table('tbl_users')
                     ->select('first_name', 'last_name', 'address', 'phone_no', 'email', 'image', 'status', 'created_date', 'created_time', 'country_name', 'name as city_name')
                     ->leftJoin('tbl_countries', 'tbl_countries.country_code', '=', 'tbl_users.country_id')
                     ->leftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_users.city_id');
                     if(!empty($request->input('customer_status') != 2)){
               $query->where('status', $request->input('customer_status'));
                     }
               $query->where('role', 2)
                     ->orderBy('tbl_users.id', 'DESC');
            $result = $query->get();

            //Check If Products are Exist Or Not
            if(!empty($result)){
                foreach($result as $row){
            		if($row->status == 0){
		            	$status = 'Active';
		            }else{
		            	$status = 'Inactive';
		            }

                 	$data[] = array(
                        'First Name' => $row->first_name,
                        'Last Name' => $row->last_name,
                        'Address' => $row->address,
                        'Phone NO#' => $row->phone_no,
                        'Email' => $row->email,
                        'Country Name' => $row->country_name,
                        'City Name' => $row->city_name,
                        'Profile Image' => public_path().'/assets/admin/images/profile_images/'.$row->image,
                        'Status' => $status,
                        'Registered Date' => date('D-M-Y', strtotime($row->created_date)),
                        'Registered Time' => date('h:i:s A', strtotime($row->created_time)),
                    );
                }
                
                //Export As Excel File
                $excel_sheet = Excel::create($request->input('name'), function($excel) use ($data){
                    $excel->sheet('Customers Details', function($sheet) use ($data){
                        $sheet->fromArray($data);
                    });
                })->download('xlsx');

                //Flash Success Msg
                $request->session()->flash('alert-success', 'Customers export successfully.');
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', 'Customers not exist for following request.');
            }

            //Reidrect
            return redirect()->back();
        }else{
            print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
        }
    }
}