<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\FileView;
use App\Models\Sector;
use App\Models\VideoView;
use App\Models\AudioView;
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

        $downloads = FileView::query();
        $views = VideoView::query();
        $plays = AudioView::query();

        return $this->ifAuthenticated('front.home', [
            'announcements' => $announcements,
            'sectors' => $sectors,
            'downloads' => $downloads,
            'views' => $views,
            'plays' => $plays,
        ]);
    }
}
