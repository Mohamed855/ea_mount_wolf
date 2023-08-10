<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    public function index() {
        if(Auth::check())
            return view('site.home');
        return redirect()->route('login');
    }
}
