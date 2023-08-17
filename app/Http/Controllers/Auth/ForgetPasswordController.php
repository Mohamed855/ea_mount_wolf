<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;

class ForgetPasswordController extends Controller
{
    use GeneralTrait;

    public function forget_password() {
        return $this->ifNotAuthenticated(
            $this->successView('auth.forget_password')
        );

    }
}
