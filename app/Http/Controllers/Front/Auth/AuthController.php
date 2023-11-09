<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function login() {
        return $this->ifNotAuthenticated(
             $this->successView('front.auth.login')
        );
    }

    public function check_credentials(LoginRequest $request) {
        $user_name = $request->input('user_name');
        $crm_code = $request->input('crm_code');
        $password = $request->input('password');
        $field = filter_var($user_name, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';

        $credentials = [$field => $user_name, 'crm_code' => $crm_code , 'password' => $password];
        if (Auth::attempt($credentials)) {
            if (DB::table('users')->where('crm_code', $crm_code)->value('activated') === 0) {
                return $this->backWithMessage('invalid', 'Your account has\'t activated yet');
            }
            return $this->redirect('home');
        }
        return $this->backWithMessage('invalid', 'Invalid credentials');
    }

    public function logout() {
        return view('front.auth.logout');
    }

    public function endSession() {
        if (Auth::check()) {
            Session::flush();
            Auth::logout();
        }
        return $this->redirect('choose-login');
    }
}
