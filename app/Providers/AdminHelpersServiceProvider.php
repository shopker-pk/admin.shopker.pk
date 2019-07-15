<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class AdminHelpersServiceProvider extends ServiceProvider{
    function register(){
        foreach (glob(app_path().'/Helpers/Admin/*.php') as $filename){
            require_once($filename);
        }
    }
}