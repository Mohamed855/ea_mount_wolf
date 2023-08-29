<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CheckPasswordRequest;
use App\Traits\GeneralTrait;
use App\Traits\AuthTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForgetPasswordController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function forget_password() {
        return $this->ifNotAuthenticated(
            $this->successView('auth.forget_password')
        );
    }

    public function check_credentials(CheckPasswordRequest $request) {
        $email = $request->input('email');
        $crm_code = $request->input('crm_code');

        $credentials = ['email' => $email, 'crm_code' => $crm_code];
        if (Auth::attempt($credentials)) {
            if (DB::table('users')->where('crm_code', $crm_code)->value('activated') === 0) {
                return $this->backWithMessage('invalid', 'Your account has\'t activated yet');
            }
            // Send email to reset password
        }
        return $this->backWithMessage('invalid', 'Invalid credentials');
    }
}
