<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function check_credentials(LoginRequest $request) {
        $user_name = $request->input('user_name');
        $crm_code = $request->input('crm_code');
        $password = $request->input('password');

        $field = filter_var($user_name, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';

        $credentials = [$field => $user_name, 'crm_code' => $crm_code , 'password' => $password];
        if (Auth::attempt($credentials))
            return redirect()->route('home');

        return redirect()->back()->with('invalid', 'Invalid credentials');
    }
}
