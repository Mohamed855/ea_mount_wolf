<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use GeneralTrait;

    public function index() {

        $sectors = DB::table('sectors')->select('id', 'name')->get();

        $announcements = DB::table('announcements')
            ->select('image', 'status')
            ->where('announcements.status', '=',1)
            ->get();

        $views = DB::table('files')->select('sector_id', 'viewed')->get();

        return $this->ifAuthenticated('site.home')->with([
            'announcements' => $announcements,
            'sectors' => $sectors,
            'views' => $views,
        ]);
    }
}
