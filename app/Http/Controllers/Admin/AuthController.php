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
            $this->successView('admin.login')
        );
    }

    public function admin_check_credentials(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        $credentials = ['email' => $email, 'password' => $password];
        if (Auth::attempt($credentials)) {
            if (auth()->user()->role == 1){
                return $this->redirect('panel');
            }
            Session::flush();
            Auth::logout();
            return $this->backWithMessage('invalid', 'Invalid credentials');
        }
        return $this->backWithMessage('invalid', 'Invalid credentials');
    }
}
