<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use GeneralTrait;
    public function dashboard()
    {
        $announcements_count = DB::table('announcements')->count();
        $sectors_count = DB::table('sectors')->count();
        $lines_count = DB::table('lines')->count();
        $users_count = DB::table('users')->count();
        $topics_count = DB::table('topics')->count();
        $files_count = DB::table('files')->count();
        $videos_count = DB::table('videos')->count();

        $file_downloads_count = DB::table('file_downloads')->count();
        $video_views_count = DB::table('video_views')->count();

        $sectors = DB::table('Sectors')->get();
        $files = DB::table('files');
        $videos = DB::table('videos');

        return $this->ifAdmin(
            $this->ifAdminAuthenticated('admin.dashboard.index')->with([
                'announcements_count' => $announcements_count,
                'sectors_count' => $sectors_count,
                'lines_count' => $lines_count,
                'users_count' => $users_count,
                'topics_count' => $topics_count,
                'files_count' => $files_count,
                'videos_count' => $videos_count,
                'sectors' => $sectors,
                'file_downloads_count' => $file_downloads_count,
                'video_views_count' => $video_views_count,
                'files' => $files,
                'videos' => $videos,
            ])
        );
    }
}
