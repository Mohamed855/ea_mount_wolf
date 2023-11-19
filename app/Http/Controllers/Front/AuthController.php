<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    use GeneralTrait;
    use AuthTrait;
    use PanelRulesTrait;
    use PanelMessagesTrait;

    public function manager_login() {
        return $this->ifNotAuthenticated(
            view('front.auth.manager_login')
        );
    }

    public function manager_check_credentials(Request $request) {
        $user_name = $request->input('user_name');
        $crm_code = $request->input('crm_code');
        $password = $request->input('password');
        $field = filter_var($user_name, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';

        $credentials = [$field => $user_name, 'crm_code' => $crm_code , 'password' => $password];
        if (Auth::attempt($credentials)) {
            if (auth()->user()->role == 2){
                if (auth()->user()->activated) {
                    return redirect()->route('home');
                }
                Session::flush();
                Auth::logout();
                return $this->backWithMessage('error', 'Your account isn\'t activated');
            }
            Session::flush();
            Auth::logout();
            return $this->backWithMessage('error', 'Invalid credentials');
        }
        return $this->backWithMessage('error', 'Invalid credentials');
    }

    public function employee_login() {
        return $this->ifNotAuthenticated(
            view('front.auth.emp_login')
        );
    }

    public function employee_check_credentials(Request $request) {
        $user_name = $request->input('user_name');
        $crm_code = $request->input('crm_code');
        $password = $request->input('password');
        $field = filter_var($user_name, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';

        $credentials = [$field => $user_name, 'crm_code' => $crm_code , 'password' => $password];
        if (Auth::attempt($credentials)) {
            if (auth()->user()->role == 3){
                if (auth()->user()->activated) {
                    return redirect()->route('home');
                }
                Session::flush();
                Auth::logout();
                return $this->backWithMessage('error', 'Your account isn\'t activated');
            }
            Session::flush();
            Auth::logout();
            return $this->backWithMessage('error', 'Invalid credentials');
        }
        return $this->backWithMessage('error', 'Invalid credentials');
    }

    public function logout() {
        return view('front.auth.logout');
    }

    public function endSession() {
        if (Auth::check()) {
            Session::flush();
            Auth::logout();
        }
        return redirect()->route('select-user');
    }
}
