<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class ChooseLoginController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function index() {
        return $this->ifNotAuthenticated(
            $this->successView('choose-login')
        );
    }
}
