<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(){
        if(auth()->check()){
            return redirect('/');
        }
        return view ('components.login');
    }

    public function register (){
        if(auth()->check()){
            return redirect ('/');
        }
        return view ('components.register');
    }

    public function logout (){
        auth()->logout();
        return redirect('/login');

    }
}
