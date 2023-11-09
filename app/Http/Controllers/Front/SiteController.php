<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function drive(string $sector_id, string $line_id)
    {
        if (Auth::check()) {
            return $this->ifAuthenticated('front.drive', [
                'user_files' => DB::table('files')
                    ->where('files.sector_id', $sector_id)
                    ->where('files.line_id', $line_id)
                    ->where('files.status', '=',1),
                'user_videos' => DB::table('videos')
                    ->where('videos.sector_id', $sector_id)
                    ->where('videos.line_id', $line_id)
                    ->where('videos.status', '=',1),
                'user_favorites_files' => DB::table('files')
                    ->join('favorites', 'files.id', '=', 'favorites.file_id')
                    ->select('favorites.file_id as file_id')
                    ->where('favorites.user_id', auth()->user()->id)
                    ->where('files.status', '=',1)
                    ->get(),
                'user_favorites_videos' => DB::table('videos')
                    ->join('favorite_videos', 'videos.id', '=', 'favorite_videos.video_id')
                    ->select('favorite_videos.video_id as video_id')
                    ->where('favorite_videos.user_id', auth()->user()->id)
                    ->where('videos.status', '=',1)
                    ->get(),
                'downloaded' => DB::table('file_downloads')
                    ->join('files', 'file_downloads.file_id', '=', 'files.id')->get(),
                'viewed' => DB::table('video_views')
                    ->join('videos', 'video_views.video_id', '=', 'videos.id')->get(),
            ]);
        }
        return $this->redirect('choose-login');
    }
    public function choose_line(string $sector_id)
    {
        return $this->ifAuthenticated('front.chooseLine', [
                'current_sector' => DB::table('sectors')->select('id', 'name')
                    ->where('id', $sector_id)->first(),
                'selected_sector_lines' => DB::table('lines')
                    ->join('line_sector', 'lines.id', '=', 'line_sector.line_id')
                    ->where('sector_id', $sector_id)
                    ->select('lines.id as line_id', 'lines.name', 'line_sector.sector_id')
                    ->orderBy('lines.name')->get(),
            ]);
    }

    public function video(string $id)
    {
        $video = DB::table('videos')->where('id', $id)->first();

        $viewed = DB::table('video_views')
            ->join('videos', 'video_views.video_id', '=', 'videos.id')->get();

        if($video) {
            if ($video->status) {
                return $this->ifAuthenticated('front.video', [
                    'video' => $video,
                    'viewed' => $viewed,
                ]);
            }
            return abort(404);
        }
        return abort(404);
    }

    public function brain_box()
    {
        $latest_topic = DB::table('topics')->latest('id')->first();

        if(Auth::check())
            return redirect()->route('topic', $latest_topic->id);
        return $this->redirect('choose-login');
    }

    public function topic(string $id)
    {
        $active_topics = DB::table('topics')->where('status', 1)->get();
        $current_topic = DB::table('topics')->where('id', $id)->first();
        $comments_details = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->join('titles', 'users.title_id', '=', 'titles.id')
            ->join('lines', 'users.line_id', '=', 'lines.id')
            ->join('sectors', 'users.sector_id', '=', 'sectors.id')
            ->select(
                'users.user_name',
                'users.profile_image',
                'comments.id',
                'comments.comment',
                'comments.user_id',
                'titles.name as user_title',
                'lines.name as user_line',
                'sectors.name as user_sector'
            )
            ->where('comments.topic_id', $id)
            ->get();

        $topic = Topic::find($id);

        if($topic) {
            if ($topic->status) {
                return $this->ifAuthenticated('front.topic', [
                    'active_topics' => $active_topics,
                    'current_topic' => $current_topic,
                    'comments_details' => $comments_details,
                ]);
            }
            return abort(404);
        }
        return abort(404);
    }
    public function createVideo()
    {
        if (Auth::user()->role == 2) {
            return $this->ifAuthenticated('front.manager.createVideo',[
                'sectors' => DB::table('sectors')->get(),
                'lines' => DB::table('lines')->get(),
                'user_sector' => DB::table('sectors')->where('id', '=', auth()->user()->sector_id)->first(),
            ]);
        } else {
            abort(404);
        }
    }
    public function createFile()
    {
        if (Auth::user()->role == 2) {
            return $this->ifAuthenticated('front.manager.createFile',[
                'sectors' => DB::table('sectors')->get(),
                'lines' => DB::table('lines')->get(),
                'user_sector' => DB::table('sectors')->where('id', '=', auth()->user()->sector_id)->first(),
            ]);
        } else {
            abort(404);
        }
    }
}
