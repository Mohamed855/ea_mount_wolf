<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\File;
use App\Models\FileLine;
use App\Models\Line;
use App\Models\Topic;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoLine;
use App\Traits\GeneralTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class ActionsController extends Controller
{
    use GeneralTrait;

    public function toggle_active($id) {
        if ($id != 1) {
            $user = User::find($id);
            if($user) {
                $user->activated ? $user->activated = 0 : $user->activated = 1;
                $user->save();
            }
        }
        return back();
    }

    public function toggle_publish_announcement($id) {
        $announcement = Announcement::find($id);
        if($announcement) {
            $announcement->status ? $announcement->status = 0 : $announcement->status = 1;
            $announcement->save();
        }
        return back();
    }

    public function toggle_publish_topic($id) {
        $topic = Topic::find($id);
        if($topic) {
            $topic->status ? $topic->status = 0 : $topic->status = 1;
            $topic->save();
        }
        return back();
    }

    public function toggle_publish_line($id) {
        $line = Line::find($id);
        if($line) {
            $line->status ? $line->status = 0 : $line->status = 1;
            $line->save();
        }
        return back();
    }

    public function toggle_show_file($id) {
        $file = File::find($id);
        if($file) {
            $file->status ? $file->status = 0 : $file->status = 1;
            $file->save();
        }
        return back();
    }

    public function toggle_show_video($id) {
        $video = Video::find($id);
        if($video) {
            $video->status ? $video->status = 0 : $video->status = 1;
            $video->save();
        }
        return back();
    }
    public function download_report($table, $id) {
        if (auth()->user()->role = 1) {

            $fileOrVideo = $table == 'file_views' ?
                File::query()->where('files.id', $id)->first() :
                Video::query()->where('videos.id', $id)->first();

            $data = DB::table($table)
                ->join('users', 'file_views.user_id', '=', 'users.id')
                ->select(
                    'users.first_name',
                    'users.middle_name',
                    'users.last_name',
                    'users.user_name',
                    'users.role',
                    'users.created_at',
                )->where('file_id', $id)->get();
            $pdf = PDF::loadView('admin.panel.files.pdf', compact(['data', 'fileOrVideo', 'table']));
            return $pdf->download($fileOrVideo->name . '_views.pdf');
        }
        return abort(404);
    }
}
