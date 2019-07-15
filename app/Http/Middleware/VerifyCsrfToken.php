<?php
namespace App\Http\Middleware;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware{
    protected $addHttpCookie = true;

    protected $except = [
        '/api/post-user-credentials',
        '/api/get-user-profile',
        '/api/post-user-login-activity-log',
    ];
}