<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    use GeneralTrait;
    use AuthTrait;
    use PanelRulesTrait;
    use PanelMessagesTrait;

    public function admin_login() {
        return $this->ifNotAuthenticated(
            view('admin.login')
        );
    }

    public function admin_check_credentials(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        $credentials = ['email' => $email, 'password' => $password];
        if (Auth::attempt($credentials)) {
            if (auth()->user()->role == 1){
                if (auth()->user()->activated){
                    return redirect()->route('panel');
                }
                Session::flush();
                Auth::logout();
                return $this->backWithMessage('error', 'Your account has been suspended');
            }
            Session::flush();
            Auth::logout();
            return $this->backWithMessage('error', 'Invalid credentials');
        }
        return $this->backWithMessage('error', 'Invalid credentials');
    }
}
