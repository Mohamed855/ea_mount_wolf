<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\File;
use App\Models\Line;
use App\Models\Sector;
use App\Models\Topic;
use App\Models\User;
use App\Models\Video;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;

class OverviewController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function overview()
    {
        return $this->ifAdmin('admin.panel.index', [
                'announcements_count' => Announcement::query()->count(),
                'sectors_count' => Sector::query()->count(),
                'lines_count' => Line::query()->count(),
                'admins_count' => User::query()->where('role', 1)->count(),
                'managers_count' => User::query()->where('role', 2)->count(),
                'employees_count' => User::query()->where('role', 3)->count(),
                'topics_count' => Topic::query()->count(),
                'files_count' => File::query()->count(),
                'videos_count' => Video::query()->count(),
                'sectors' => Sector::query()->get(),
            ]);
    }
}
