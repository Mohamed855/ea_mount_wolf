<?php

namespace App\Traits;

use App\Models\CommentNotification;
use App\Models\FileNotification;
use App\Models\TopicNotification;
use App\Models\User;
use App\Models\VideoNotification;
use App\Models\AudioNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

trait AuthTrait {
    use GeneralTrait;

    public function ifAdmin ($view, $data = []): View|RedirectResponse
    {
        if(Auth::check()) {
            if (auth()->user()->role === 1) {
                return view($view)->with($data);
            }
            return redirect()->route('not_authorized');
        }
        return redirect()->route('select-user');
    }
    public function ifAuthenticated ($view, $data): View|RedirectResponse
    {
         if(Auth::check()) {
            if (auth()->user()->activated) {
                $current_user_details = User::query()->join('titles', 'users.title_id', '=', 'titles.id')
                    ->select('users.user_name',
                        'titles.name as title_name',
                    )->where('users.id', auth()->id())
                    ->first();

                $video_notifications = [];
                $audio_notifications = [];
                $file_notifications = [];
                $topic_notifications = TopicNotification::query()->get();
                $comment_notifications = CommentNotification::query()->get();

                if (auth()->user()->role == 1) {
                    $video_notifications = VideoNotification::query()->get();
                    $audio_notifications = AudioNotification::query()->get();
                    $file_notifications = FileNotification::query()->get();
                }
                elseif (auth()->user()->role == 2) {
                    $video_notifications = VideoNotification::query()->whereIn('sector_id', auth()->user()->sectors)->get();
                    $audio_notifications = AudioNotification::query()->whereIn('sector_id', auth()->user()->sectors)->get();
                    $file_notifications = FileNotification::query()->whereIn('sector_id', auth()->user()->sectors)->get();
                }
                elseif (auth()->user()->role == 3) {
                    $video_notifications = VideoNotification::query()->whereIn('sector_id', auth()->user()->sectors)->whereIn('line_id', auth()->user()->lines)->get();
                    $audio_notifications = AudioNotification::query()->whereIn('sector_id', auth()->user()->sectors)->whereIn('line_id', auth()->user()->lines)->get();
                    $file_notifications = FileNotification::query()->whereIn('sector_id', auth()->user()->sectors)->whereIn('line_id', auth()->user()->lines)->get();
                }
                return view($view)
                    ->with([
                        'user_details' => $current_user_details,
                        'video_notifications' => $video_notifications,
                        'audio_notifications' => $audio_notifications,
                        'file_notifications' => $file_notifications,
                        'comment_notifications' => $comment_notifications,
                        'topic_notifications' => $topic_notifications,
                    ])->with($data);
            } else {
                Session::flush();
                Auth::logout();
                return redirect()->route('select-user');
            }
        }
        return redirect()->route('select-user');
    }
    public function ifNotAuthenticated ($return) {
        if (!Auth::check())
            return $return;
        return redirect()->route('home');
    }
}
