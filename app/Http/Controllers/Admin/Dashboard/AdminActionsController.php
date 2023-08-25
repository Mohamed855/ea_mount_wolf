<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\File;
use App\Models\Topic;
use App\Models\User;
use App\Models\Video;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminActionsController extends Controller
{
    use GeneralTrait;

    public function toggle_active($id) {
        $user = User::find($id);
        if($user) {
            $user->activated ? $user->activated = 0 : $user->activated = 1;
            $user->save();
        }
        return $this->redirect('users.index');
    }

    public function toggle_publish_announcement($id) {
        $announcement = Announcement::find($id);
        if($announcement) {
            $announcement->status ? $announcement->status = 0 : $announcement->status = 1;
            $announcement->save();
        }
        return $this->redirect('announcements.index');
    }

    public function toggle_publish_topic($id) {
        $topic = Topic::find($id);
        if($topic) {
            $topic->status ? $topic->status = 0 : $topic->status = 1;
            $topic->save();
        }
        return $this->redirect('ea_topics.index');
    }

    public function toggle_show_file($id) {
        $file = File::find($id);
        if($file) {
            $file->status ? $file->status = 0 : $file->status = 1;
            $file->save();
        }
        return $this->redirect('ea_files.index');
    }

    public function toggle_show_video($id) {
        $video = Video::find($id);
        if($video) {
            $video->status ? $video->status = 0 : $video->status = 1;
            $video->save();
        }
        return $this->redirect('videos.index');
    }
}
