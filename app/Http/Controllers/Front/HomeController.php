<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\FileView;
use App\Models\Sector;
use App\Models\VideoView;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;

class HomeController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function index() {

        $sectors = Sector::query()->select('id', 'name')->get();

        $announcements = Announcement::query()->select('image', 'status')
            ->where('announcements.status', '=',1)
            ->get();

        $downloads = FileView::query()->join('files', 'file_views.file_id', '=', 'files.id')
            ->select(
                'files.sector_id as sector_id'
            )->get();

        $views = VideoView::query()->join('videos', 'video_views.video_id', '=', 'videos.id')
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
