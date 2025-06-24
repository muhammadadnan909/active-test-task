<?php


// namespace App\Http\Controllers\Admin\Auth;

// use App\Http\Controllers\Controller;
// use App\Providers\RouteServiceProvider;
// use Illuminate\Foundation\Admin\Auth\AuthenticatesUsers;
// use Illuminate\Http\Request;

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Admin\Auth\AuthenticatesAdminUsers;
class LoginController extends Controller
{
    //
     use AuthenticatesAdminUsers;

    protected function guard()
    {
        return auth()->guard('admin');
    }

}
