<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function dashboard()
    {
        return $this->ifAdmin('admin.dashboard.index', [
                'announcements_count' => DB::table('announcements')->count(),
                'sectors_count' => DB::table('sectors')->count(),
                'lines_count' => DB::table('lines')->count(),
                'users_count' => DB::table('users')->count(),
                'topics_count' => DB::table('topics')->count(),
                'files_count' => DB::table('files')->count(),
                'videos_count' => DB::table('videos')->count(),
                'sectors' => DB::table('Sectors')->get(),
                'file_downloads_count' => DB::table('file_downloads')->count(),
                'video_views_count' => DB::table('video_views')->count(),
                'files' => DB::table('files'),
                'videos' => DB::table('videos'),
            ]);
    }
}
