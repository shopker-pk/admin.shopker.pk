<?php 
use Illuminate\Contracts\View\View;
namespace App\Http\Composers;
use Session;
use DB;

class PanelHeaderComposer{
    function index($view){
        //Query For Getting User data
    	$query = DB::table('tbl_users')
                     ->select('*')
                     ->leftJoin('tbl_site_settings', 'tbl_site_settings.admin_id', '=', 'tbl_users.id')
                     ->leftJoin('tbl_site_images', 'tbl_site_images.admin_id', '=', 'tbl_users.id')
                     ->leftJoin('tbl_cities', 'tbl_cities.id', '=', 'tbl_users.city_id')
                     ->leftJoin('tbl_countries', 'tbl_countries.id', '=', 'tbl_users.country_id')
                     ->where('tbl_users.id', session::get('id'));
        $result = $query->first();

        //Return Data
        $view->with('result', $result);
    }
}