<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use GeneralTrait;

    public function index() {
        $sectors = DB::table('sectors')->get();
        $announcements= DB::table('announcements')->get();

        return $this->ifAuthenticated('site.home')->with([
            'sectors' => $sectors,
            'announcements' => $announcements,
        ]);
    }
}
