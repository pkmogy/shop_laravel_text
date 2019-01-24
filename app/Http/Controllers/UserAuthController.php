<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class UserAuthController extends Controller{
    public function signUpPage(){
        $binding=['title' => '註冊',];
        return view('auth.signUp',$binding);
    }
}