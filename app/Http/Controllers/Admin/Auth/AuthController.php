<?php
namespace App\Http\Controllers\Admin\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use DB;

class AuthController extends Controller{
    function index(Request $request){
    	if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Redirect to dashboard
            return redirect()->route('admin_dashboard');
        }else{
        	//Header Data
	    	$result = array(
	            'page_title' => 'Sign In',
	            'meta_keywords' => 'sign_in',
	            'meta_description' => 'sign_in',
	        );

            //Query For Getting Logo and Store Name
            $query = DB::table('tbl_site_settings')
                         ->select('tbl_site_settings.title', 'tbl_site_images.header_image')
                         ->leftJoin('tbl_site_images', 'tbl_site_images.admin_id', '=', 'tbl_site_settings.admin_id');
            $result['query'] = $query->first();

	        //call page
	        return view('admin.auth.sign_in', $result); 
    	}
    }

    function validating_admin_credentials(Request $request){
    	if(!empty($request->input('email') && $request->input('password'))){
            //All Inputs Gets in Array Form
            $inputs = [
                $ip = $request->ip(),
                $email_address = $request->input('email'),
                $password = sha1($request->input('password')),
            ];

            //Inputs Validation
            $input_validations = $request->validate([
                'email' => 'required|email|String',
                'password' => 'required|min:8|regex:/^((?=.*[a-z]))((?=.*[A-Z]))((?=.*[0-9])).+$/',
            ]);

            //check user email and password in table
            $query = DB::table('tbl_users')
                         ->select('*')
                         ->where('email', '=', $email_address)
                         ->where('password', '=', $password)
                         ->where('role', '=', 0)
                         ->where('status', '=', 0);
            $result = $query->first();

            //if user data found then sign in else redirect with error msg
            if($result){
                //User data
                $user_id = $result->id;
                $user_role = $result->role;
                $user_email = $result->email;

                //Flash Erro Msg
                $request->session()->flash('alert-success', 'You are login successfully');
                
                //Set data accordings to table columns
                $data = array(
                    'ip_address' => $ip,
                    'user_id' => $user_id,
                    'status' => 0,
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                );

                //Insert data in table
                $query = DB::table('tbl_login_activities')
                             ->insertGetId($data);

                //Storing User Id In session
                $store_session = session([
                    'id' => $user_id, 
                    'role' => $user_role,
                ]);
                
                //Redirect to dashboard
                return redirect()->route('admin_dashboard');
            }else{
                //Flash Error Msg
                $request->session()->flash('alert-danger', 'You are using wrong credentials for sign in');

                //Redirect to sign up page
                return redirect()->route('admin_sign_in');
            }
        }else{
            //Flash Erro Msg
            $request->session()->flash('alert-danger', 'Enter Credentials First !!');

            //Redirect to sign up page
            return redirect()->route('admin_sign_in');  
        }
    }

    function sign_out(Request $request){
    	//Set data accordings to table columns
        $data = array(
            'ip_address' => $request->ip(),
            'user_id' => $request->session()->has('id'),
            'status' => 1,
            'date' => date('Y-m-d'),
            'time' => date('H:i:s'),
        );

        //Insert data in table
        $query = DB::table('tbl_login_activities')
                     ->insertGetId($data);

    	//Delete Session
        Session::flush();

        //Redirect
        return redirect()->route('admin_sign_in');
    }
}