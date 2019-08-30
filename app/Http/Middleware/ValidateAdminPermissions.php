<?php
namespace App\Http\Middleware;
use Closure;
use Session;
use DB;

class ValidateAdminPermissions{
    function handle($request, Closure $next, $permission){
        if(Session::get('role') == 0){
            return $next($request);
        }elseif(Session::get('role') == 1){
            //Query For Getting User data
            $query = DB::table('tbl_admin_permissions')
                         ->select('permission_id')
                         ->where('permission_id', $permission)
                         ->where('admin_id', Session::get('id'));
            $result = $query->first();
            
            if(!empty($result)){
                return $next($request);
            }else{
                //Flash Error Message
                $request->session()->flash('alert-danger', "You don't have access of this page.");

                return redirect()->back();
            }
        }
    }
}