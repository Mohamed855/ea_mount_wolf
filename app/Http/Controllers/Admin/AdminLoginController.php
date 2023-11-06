<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Traits\GeneralTrait;
use App\Traits\AuthTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminLoginController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function admin_login() {
        return $this->ifNotAuthenticated(
            $this->successView('admin.login')
        );
    }

    public function admin_check_credentials(AdminLoginRequest $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        $credentials = ['email' => $email, 'password' => $password];
        if (Auth::attempt($credentials)) {
            if (auth()->user()->role == 1){
                return $this->redirect('dashboard');
            }
            Session::flush();
            Auth::logout();
            return $this->backWithMessage('invalid', 'Invalid credentials');
        }
        return $this->backWithMessage('invalid', 'Invalid credentials');
    }

    public function logout() {
        if (Auth::check()) {
            Session::flush();
            Auth::logout();
        }
        return $this->redirect('admin.login');
    }
}