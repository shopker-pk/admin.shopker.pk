<?php
namespace App\Http\Controllers\Admin\Ecommerce;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class VariationsController extends Controller{
	function index(Request $request){
    	//Necessary Page Data For header Page
        $result = array(
            'page_title' => 'Manage Variations',
            'meta_keywords' => '',
            'meta_description' => '',
        ); 

        //Query for Getting Data
    	$query = DB::table('tbl_variations_for_products')
    	             ->select('id', 'label', 'status')
    	             ->orderBy('id', 'DESC')
    	             ->groupBy('label');
 		$result['query'] = $query->paginate(10);
 		$result['total_records'] = $result['query']->count();

 		//call page
		return view('admin.ecommerce.variations.manage', $result); 
    }

    function add(Request $request){
    	//Necessary Page Data For header Page
        $result = array(
            'page_title' => 'Add Variations',
            'meta_keywords' => '',
            'meta_description' => '',
        ); 

 		//call page
		return view('admin.ecommerce.variations.add', $result); 
 	}

    function insert(Request $request){
    	//Get All Inputs
    	$user_id = $request->session()->get('id');
    	$ip_address = $request->ip();
        $label = $request->input('label');
        $values = $request->input('value');
        $status = $request->input('status', '0');
    	$created_date = date('Y-m-d');
        $created_time = date('H:i:s');

    	//Inputs Validation
        $input_validations = $request->validate([
            'label' => 'required',
            'value' => 'nullable|unique:tbl_variations_for_products',
            'status' => 'required',
        ]);

        //insert array of values
        foreach($values as $value){
        	//Set Field data according to table column
	        $data = array(
	        	'ip_address' => $ip_address,
	        	'user_id' => $user_id,
	        	'label' => $label,
	        	'value' => $value,
	        	'status' => $status,
	        	'created_date' => $created_date,
	        	'created_time' => $created_time,
        	);

        	//Query For Inserting Data
	    	$query = DB::table('tbl_variations_for_products')
	    	             ->insertGetId($data);
        }

        //Check either data inserted or not
     	if(!empty($query)){
     		//Flash Success Message
     		$request->session()->flash('alert-success', 'Variation has been added successfully');
     	}else{
     		//Flash Error Message
     		$request->session()->flash('alert-danger', 'Something went wrong !!');
     	}

     	//Redirect 
     	return redirect()->route('add_variations');
    }

    function ajax_update_status(Request $request, $id, $status){
		if($status == 0){
            $status = 1;
        }elseif($status == 1){
            $status = 0;
        }

        $query = DB::table('tbl_variations_for_products')
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
	}

    function edit(Request $request, $label){
    	//Necessary Page Data For header Page
        $result = array(
            'page_title' => 'Edit Variations',
            'meta_keywords' => '',
            'meta_description' => '',
        ); 

        //Query for Getting Data
    	$query = DB::table('tbl_variations_for_products')
    	             ->select('id', 'label', 'status')
    	             ->where('label', $label);
 		$result['query'] = $query->first();
 		
 		//Query For getting values of this label
 		$query = DB::table('tbl_variations_for_products')
    	             ->select('*')
    	             ->where('label', $result['query']->label);
 		$result['values'] = $query->get();
 		
 		if(!empty($result['query'])){
	 		//call page
 			return view('admin.ecommerce.variations.edit', $result); 
			}else{
        	print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
    	}
    }

    function update(Request $request, $id){
    	//Query for Getting label of current data
    	$query = DB::table('tbl_variations_for_products')
    	             ->select('label')
    	             ->where('id', $id);
 		$result['query'] = $query->first();

		//Query for Deleting previous data
		$query = DB::table('tbl_variations_for_products')
		             ->where('label', $result['query']->label)
		             ->delete();

		//Get All Inputs
    	$user_id = $request->session()->get('id');
    	$ip_address = $request->ip();
        $label = $request->input('label');
        $values = $request->input('value');
        $status = $request->input('status');
    	$created_date = date('Y-m-d');
        $created_time = date('H:i:s');

    	//Inputs Validation
        $input_validations = $request->validate([
            'label' => 'required',
            'value' => 'nullable|unique:tbl_variations_for_products,id,'.$id,
            'status' => 'required',
        ]);

        //insert array of values
        foreach($values as $value){
        	//Set Field data according to table column
	        $data = array(
	        	'ip_address' => $ip_address,
	        	'user_id' => $user_id,
	        	'label' => $label,
	        	'value' => $value,
	        	'status' => $status,
	        	'created_date' => $created_date,
	        	'created_time' => $created_time,
        	);

        	//Query For Inserting Data
	    	$query = DB::table('tbl_variations_for_products')
	    	             ->insertGetId($data);
        }

        //Check either data inserted or not
     	if(!empty($query)){
     		//Flash Success Message
     		$request->session()->flash('alert-success', 'Variation has been updated successfully');
     	}else{
     		//Flash Error Message
     		$request->session()->flash('alert-danger', 'Something went wrong !!');
     	}

     	//Redirect 
     	return redirect()->back();
    }

    function delete(Request $request, $label){
    	//Query For Deleting Data
		$query = DB::table('tbl_variations_for_products')
		             ->where('label', $label)
		             ->delete();

     	//Check either data deleted or not
     	if(!empty($query)){
     		//Flash Success Message
     		$request->session()->flash('alert-success', 'Variations has been deleted successfully');
     	}else{
     		//Flash Error Message
     		$request->session()->flash('alert-danger', 'Something went wrong !!');
     	}

     	//Redirect 
     	return redirect()->route('manage_variations');
    }

    function import(Request $request){
    	//Inputs Validation
        $input_validations = $request->validate([
            'file' => 'required|mimes:csv,xls,xlsx',
        ]);

        //Import Excel File
        $path = $request->file('file')->getRealPath();
    	$data = Excel::load($path)->get(); 
		
		if(!empty($data) && $data->count()){
			foreach($data->toArray() as $row){
		        if(!empty($row)){
		            $data = [
	                	'user_id' => $request->session()->get('id'),
        				'ip_address' => $request->ip(),
		                'label' => $row['label'],
		                'value' => $row['value'],
		                'status' => 0,
		                'created_date' => date('Y-m-d'),
		                'created_time' => date('h:i:s'),
	                ];
	        		
	        		if(!empty($data)){
		                //Query For Inserting Data
				    	$query = DB::table('tbl_variations_for_products')
				    	             ->insertGetId($data);
		            }
            	}
 			}
		}

    	//Check either data imported or not
     	if(!empty($query)){
     		//Flash Success Message
     		$request->session()->flash('alert-success', 'Variations has been import successfully');
     	}else{
     		//Flash Error Message
     		$request->session()->flash('alert-danger', 'Something went wrong !!');
     	}

     	//Redirect 
     	return redirect()->route('manage_variations');
    }

    function export(Request $request){
    	$query = DB::table('tbl_variations_for_products')
		             ->select('label', 'value')
		             ->where('label', $request->input('label'));
     	$results = $query->get();

     	if(!empty($results)){
     		$result = array();
     		foreach($results as $row){
     			$data = array(
	         		'label' => $row->label,
	         		'value' => $row->value,
	         	);

	         	$result[] = (array)$data;
     		}
     		

     		//Export As Excel File
	        $excel_sheet = Excel::create($request->input('name'), function($excel) use ($result){
	            $excel->sheet('New sheet', function($sheet) use ($result){
	                $sheet->fromArray($result);
	            });
	        })->download('xlsx');
	        
	        //Flash Success Message
     		$request->session()->flash('alert-success', 'Variations has been export successfully');
     	}else{
     		//Flash Error Message
	     		$request->session()->flash('alert-danger', 'No records found for export.');
     	}
     	
     	//Redirect 
     	return redirect()->route('manage_variations');
	}

    function search(Request $request){
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
		$query = DB::table('tbl_variations_for_products')
                     ->select('*');
                     if(!empty($request->input('name'))){
               $query->where('label', 'Like', '%'.$request->input('name').'%');
                 	 }
                     if(!empty($request->input('status'))){
               $query->where('status', $request->input('status'));
                 	 }
               $query->orderBy('id', 'DESC')
                     ->groupBy('label');
        $result['query'] = $query->paginate(10);
 		$result['total_records'] = $result['query']->count();

        //call page
 		return view('admin.ecommerce.variations.manage', $result); 
    }
}