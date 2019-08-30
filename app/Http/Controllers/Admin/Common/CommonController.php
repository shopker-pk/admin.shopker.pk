<?php
namespace App\Http\Controllers\Admin\Common;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class CommonController extends Controller{
	function get_ajax_cities_list(Request $request, $id){
    	//Query For Getting Cities
 		$query = DB::table('tbl_cities')
    	             ->select('*')
    	             ->where('country_id', $id);
 		$result = $query->get();

 		//initializing Generate data variables
        $ajax_response_data = array(
            'ERROR' => 'FALSE',
            'DATA' => '',
        );

        $html = '';
        if(count($result) > 0){
        	foreach($result as $row){
        		$html .= '<option value='.$row->id.'>'.$row->name.'</option>';
        	}
        	$ajax_response_data = array(
	            'ERROR' => 'FALSE',
	            'DATA' => $html,
	        );
            echo json_encode($ajax_response_data);
        }else{
        	$html .= '<option>No City Found !!</option>';
            $ajax_response_data = array(
	            'ERROR' => 'TRUE',
	            'DATA' => $html,
	        );
            echo json_encode($ajax_response_data);
        }
        die;
	}

	function get_parent_categories(Request $request){
		//Query For Getting Cities
 		$query = DB::table('tbl_parent_categories')
    	             ->select('*')
    	             ->where('status', 0)
    	             ->orderBy('id', 'DESC');
 		$result = $query->get();

 		//initializing Generate data variables
        $ajax_response_data = array(
            'ERROR' => 'FALSE',
            'DATA' => '',
        );

        $html = '';
        if(count($result) > 0){
        	foreach($result as $row){
        		$html .= '<option value='.$row->id.'>'.$row->name.'</option>';
        	}
        	$ajax_response_data = array(
	            'ERROR' => 'FALSE',
	            'DATA' => $html,
	        );
            echo json_encode($ajax_response_data);
        }
        die;
	}

	function get_products(Request $request){
		//Query For Getting Products
    	$query = DB::table('tbl_products')
    	             ->select('id', 'name')
    	             ->where('status', 0)
    	             ->orderBy('id', 'DESC');
     	$result = $query->get();

     	//initializing Generate data variables
        $ajax_response_data = array(
            'ERROR' => 'FALSE',
            'DATA' => '',
        );

        $html = '';
        if(count($result) > 0){
        	foreach($result as $row){
        		$html .= '<option value='.$row->id.'>'.$row->name.'</option>';
        	}
        	$ajax_response_data = array(
	            'ERROR' => 'FALSE',
	            'DATA' => $html,
	        );
            echo json_encode($ajax_response_data);
        }
        die;
	}
}