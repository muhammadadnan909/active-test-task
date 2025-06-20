<?php


namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Admin\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
     use AuthenticatesUsers;

    protected function guard()
    {
        return auth()->guard('admin');
    }

}
