<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\File;
use App\Models\Line;
use App\Models\Topic;
use App\Models\User;
use App\Models\Video;
use App\Models\Audio;
use App\Traits\GeneralTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

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

    public function resetPassword($id): View
    {
        return view('admin.panel.reset_password', compact(['id']));
    }

    public function updatePassword(Request $request, $id):RedirectResponse
    {
        try {
            $passwords = $request->only('password', 'password_confirmation');
            $validator = Validator::make($passwords,  [
                'password' => 'required|string|min:8|max:16|confirmed',
            ]);

            if ($validator->fails())
                return back()->with('error', $validator->messages()->first());

            $user = User::query()->findOrFail($id);

            $newPassword = Hash::make($passwords['password']);
            DB::table('passwords')->insert([
                'password' => $passwords['password'],
                'hashed_password' => $newPassword
            ]);

            $user->update([
                'password' => $newPassword,
            ]);

            return back()->with('success', 'Password updated successfully');
        } catch (Exception) {
            return back()->with('error', 'Something went wrong');
        }
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

    public function toggle_show_audio($id) {
        $audio = Audio::find($id);
        if($audio) {
            $audio->status ? $audio->status = 0 : $audio->status = 1;
            $audio->save();
        }
        return back();
    }
    public function download_report($table, $id) {
        if (auth()->user()->role = 1) {

                if ($table == 'file_views') {
                    $fileOrVideoOrAudio = File::query()->where('files.id', $id)->first();
                } elseif ($table == 'video_views') {
                    $fileOrVideoOrAudio = Video::query()->where('videos.id', $id)->first();
                } elseif ($table == 'audio_views') {
                    $fileOrVideoOrAudio = Audio::query()->where('audios.id', $id)->first();
                } else {
                    abort(404);
                }

            $data = DB::table($table);

            if ($table == 'file_views') {
                $data = $data->join('users', 'file_views.user_id', '=', 'users.id');
            } elseif ($table == 'video_views') {
                $data = $data->join('users', 'video_views.user_id', '=', 'users.id');
            } elseif ($table == 'audio_views') {
                $data = $data->join('users', 'audio_views.user_id', '=', 'users.id');
            }

            $data->select(
                    'users.first_name',
                    'users.middle_name',
                    'users.last_name',
                    'users.user_name',
                    'users.role',
                    'users.created_at',
                );

            if ($table == 'file_views') {
                $data = $data->where('file_id', $id)->get();
            } elseif ($table == 'video_views') {
                $data = $data->where('video_id', $id)->get();
            } elseif ($table == 'audio_views') {
                $data = $data->where('audio_id', $id)->get();
            }

            $pdf = PDF::loadView('admin.panel.files.pdf', compact(['data', 'fileOrVideoOrAudio', 'table']));
            return $pdf->download($fileOrVideoOrAudio->name . '_views.pdf');
        }
        abort(404);
    }
}
