<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

trait AuthTrait {
    use GeneralTrait;

    public function ifAdmin ($view, $data = []) {
        if(Auth::check()) {
            if (auth()->user()->role === 1) {
                return $this->successView($view)->with($data);
            }
            return $this->redirect('not_authorized');
        }
        return $this->redirect('select-user');
    }
    public function ifAuthenticated ($view, $data) {
         if(Auth::check()) {
            if (auth()->user()->activated) {
                $current_user_details = DB::table('users')
                    ->join('titles', 'users.title_id', '=', 'titles.id')
                    ->select('users.user_name',
                        'titles.name as title_name',
                    )->where('users.id', auth()->user()->id)
                    ->first();

                $video_notifications = [];
                $file_notifications = [];
                $comment_notifications = [];
                $topic_notifications = DB::table('topic_notifications')->get();

                if (auth()->user()->role == 1) {
                    $video_notifications = DB::table('video_notifications')->get();
                    $file_notifications = DB::table('file_notifications')->get();
                    $comment_notifications = DB::table('comment_notifications')->get();
                }
                elseif (auth()->user()->role == 2) {
                    $video_notifications = DB::table('video_notifications')->where('sector_id', auth()->user()->sector_id)->get();
                    $file_notifications = DB::table('file_notifications')->where('sector_id', auth()->user()->sector_id)->get();
                    $comment_notifications = DB::table('comment_notifications')->get();
                }
                elseif (auth()->user()->role == 3) {
                    $video_notifications = DB::table('video_notifications')->where('sector_id', auth()->user()->sector_id)->where('line_id', auth()->user()->line_id)->get();
                    $file_notifications = DB::table('file_notifications')->where('sector_id', auth()->user()->sector_id)->where('line_id', auth()->user()->line_id)->get();
                    $comment_notifications = DB::table('comment_notifications')->get();
                }
                return $this->successView($view)
                    ->with([
                        'user_details' => $current_user_details,
                        'video_notifications' => $video_notifications,
                        'file_notifications' => $file_notifications,
                        'comment_notifications' => $comment_notifications,
                        'topic_notifications' => $topic_notifications,
                    ])->with($data);
            } else {
                Session::flush();
                Auth::logout();
                return $this->redirect('login')->with('activeRequest', 'Your account is not activated');
            }
        }
        return $this->redirect('select-user');
    }
    public function ifNotAuthenticated ($return) {
        if (!Auth::check())
            return $return;
        return $this->redirect('home');
    }
}
