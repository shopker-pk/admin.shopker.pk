<?php
namespace App\Http\Controllers\Admin\Dashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class DashboardController extends Controller{
	function index(Request $request){
    	if(!empty($request->session()->has('id')) && $request->session()->get('role') == 0){
            //Necessary Page Data For header Page
            $result = array(
                'page_title' => 'Admin Dashboard',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Call Page
            return view('admin.dashboard.dashboard', $result);
        }else{
			print_r("<center><h4>Error 404 !!<br> You don't have accees of this page<br> Please move back<h4></center>");
		}
    }
}