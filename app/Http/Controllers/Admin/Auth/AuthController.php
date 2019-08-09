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
            return redirect()->back();
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
                'password' => 'nullable|min:8|regex:/^((?=.*[a-z]))((?=.*[A-Z]))((?=.*[0-9])).+$/',
            ]);

            //check user email and password in table
            $query = DB::table('tbl_users')
                         ->select('*')
                         ->where('email', 'like', '%'.$email_address.'%')
                         ->where('password', $password)
                         ->where('role', '<=', 1)
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

    function forget_password(Request $request){
        if(!empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Redirect to dashboard
            return redirect()->back();
        }else{
            //Header Data
            $result = array(
                'page_title' => 'Forget Password',
                'meta_keywords' => '',
                'meta_description' => '',
            );

            //Query For Getting Logo and Store Name
            $query = DB::table('tbl_site_settings')
                         ->select('tbl_site_settings.title', 'tbl_site_images.header_image')
                         ->leftJoin('tbl_site_images', 'tbl_site_images.admin_id', '=', 'tbl_site_settings.admin_id');
            $result['query'] = $query->first();

            //call page
            return view('admin.auth.forget_password', $result); 
        }
    }

    function sent_password(Request $request){
        if(empty($request->session()->has('id') && $request->session()->get('role') == 0)){
            //Inputs Validation
            $input_validations = $request->validate([
                'email' => 'required|email',
            ]);

            //Query For Checking if email is exist or not
            $query = DB::table('tbl_users')
                         ->select('id', 'first_name', 'last_name')   
                         ->where('email', 'like', '%'.$request->input('email').'%')
                         ->where('role', '<=', 1);
            $result = $query->first();

            if(!empty($result->id)){
                $new_password =  'S'.rand(111111, 999999).'r';

                //Set data accordings to table columns
                $data = array(
                    'ip_address' => $request->ip(),
                    'password' => sha1($new_password),
                );

                //Insert data in table
                $query = DB::table('tbl_users')
                             ->where('email', 'like', '%'.$request->input('email').'%')
                             ->where('role', '<=', 1)
                             ->update($data);

                if($query == 1){
                    //Query For Getting Logo
                    $query = DB::table('tbl_site_images')
                                 ->select('header_image');
                    $result = $query->first();

                    $data = array(
                        'content' => 'Your new password is '.$new_password.' Dear',
                        'website_url' => route('home'),
                        'logo' => env('ADMIN_URL').'images/settings/logo/'.$result->header_image,
                        'name' => $result->first_name.' '.$result->last_name,
                        'email' => $request->input('email'),
                        'type' => 'forget_password',
                    );

                    \Mail::send(['html' => 'admin.email_templates.template'], $data, function($message) use ($data){
                        $message->to($data['email'], $data['name'])
                                ->subject('Forget Password.')
                                ->from('admin@shopker.pk', 'Shopker');
                    });

                    //Flash Erro Msg
                    $request->session()->flash('alert-success', 'We have sent you a new password at your given email.');
                }else{
                    //Flash Erro Msg
                    $request->session()->flash('alert-danger', "Something went wrong !!");
                }
            }else{
                //Flash Erro Msg
                $request->session()->flash('alert-danger', "We have not found any record.");
            }

            //Redirect
            return redirect()->route('forget_password');
        }else{
            //Redirect to sign up page
            return redirect()->back();  
        }
    }
}