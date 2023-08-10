<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function sign_up() {
        return view('auth.sign_up');
    }
    public function login() {
        return view('auth.login');
    }
    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }
    public function forget_password() {
        return view('auth.forget_password');
    }
}
