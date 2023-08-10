<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function brain_box() {
        return view('site.brain-box');
    }

    public function favorites() {
        return view('site.favorites');
    }

    public function incentive() {
        return view('site.incentive');
    }

    public function videos() {
        return view('site.video');
    }
}
