<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminLoginController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function showLoginForm(){
    	return view('auth.admin-login');
    }
    public function login(){
    	return true;
    }
}
