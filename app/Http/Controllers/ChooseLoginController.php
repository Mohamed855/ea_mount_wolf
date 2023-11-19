<?php

namespace App\Http\Controllers;

use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;

class ChooseLoginController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function index() {
        return $this->ifNotAuthenticated(
            view('select-user')
        );
    }
}
