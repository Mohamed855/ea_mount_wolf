<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function index() {

        $sectors = DB::table('sectors')->select('id', 'name')->get();

        $announcements = DB::table('announcements')
            ->select('image', 'status')
            ->where('announcements.status', '=',1)
            ->get();

        $downloads = DB::table('file_downloads')
            ->join('files', 'file_downloads.file_id', '=', 'files.id')
            ->select(
                'files.sector_id as sector_id'
            )->get();

        $views = DB::table('video_views')
            ->join('videos', 'video_views.video_id', '=', 'videos.id')
            ->select(
                'videos.sector_id as sector_id'
            )->get();

        return $this->ifAuthenticated('front.home', [
            'announcements' => $announcements,
            'sectors' => $sectors,
            'downloads' => $downloads,
            'views' => $views,
        ]);
    }
}
