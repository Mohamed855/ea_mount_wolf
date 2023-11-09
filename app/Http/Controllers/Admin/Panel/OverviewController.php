<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class OverviewController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function overview()
    {
        return $this->ifAdmin('admin.panel.index', [
                'announcements_count' => DB::table('announcements')->count(),
                'sectors_count' => DB::table('sectors')->count(),
                'lines_count' => DB::table('lines')->count(),
                'admins_count' => DB::table('users')->where('role', 1)->count(),
                'managers_count' => DB::table('users')->where('role', 2)->count(),
                'employees_count' => DB::table('users')->where('role', 3)->count(),
                'topics_count' => DB::table('topics')->count(),
                'files_count' => DB::table('files')->count(),
                'videos_count' => DB::table('videos')->count(),
                'sectors' => DB::table('sectors')->get(),
                'file_downloads_count' => DB::table('file_downloads')->count(),
                'video_views_count' => DB::table('video_views')->count(),
                'files' => DB::table('files'),
                'videos' => DB::table('videos'),
            ]);
    }
}
