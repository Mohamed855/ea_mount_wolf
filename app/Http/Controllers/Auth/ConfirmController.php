<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;

class ConfirmController extends Controller
{
    use GeneralTrait;
    use AuthTrait;
    public function confirm_email() {
        return $this->successView('auth.confirm.confirm');
    }
}
