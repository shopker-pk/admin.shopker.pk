<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use Session;
use DB;
use View;

class PanelHeaderProvider extends ServiceProvider{
    function boot(){
        View::composer('admin.layouts.header', 'App\Http\Composers\PanelHeaderComposer@index');
    }

    function register(){
    	
    }
}