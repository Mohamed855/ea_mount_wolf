<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\Sector;
use App\Models\Topic;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    use GeneralTrait;

    public function drive(string $sector_id, string $line_id)
    {
        $user_files = DB::table('files')
            ->where('files.sector_id', $sector_id)
            ->where('files.line_id', $line_id)
            ->where('files.status', '=',1);

        $user_favorites_files= DB::table('files')
            ->join('favorites', 'files.id', '=', 'favorites.file_id')
            ->select('favorites.file_id as file_id')
            ->where('favorites.user_id', auth()->user()->id)
            ->where('files.status', '=',1)
            ->get();

        $user_videos = DB::table('videos')
            ->where('videos.sector_id', $sector_id)
            ->where('videos.line_id', $line_id)
            ->where('videos.status', '=',1);

        $user_favorites_videos = DB::table('videos')
            ->join('favorite_videos', 'videos.id', '=', 'favorite_videos.video_id')
            ->select('favorite_videos.video_id as video_id')
            ->where('favorite_videos.user_id', auth()->user()->id)
            ->where('videos.status', '=',1)
            ->get();

        $downloaded = DB::table('file_downloads')
            ->join('files', 'file_downloads.file_id', '=', 'files.id')->get();

        $viewed = DB::table('video_views')
            ->join('videos', 'video_views.video_id', '=', 'videos.id')->get();

        return $this->ifAuthenticated('site.drive')->with([
            'user_files' => $user_files,
            'user_videos' => $user_videos,
            'user_favorites_files' => $user_favorites_files,
            'user_favorites_videos' => $user_favorites_videos,
            'downloaded' => $downloaded,
            'viewed' => $viewed,
        ]);
    }
    public function choose_line(string $sector_id)
    {
        $selected_sector_lines = DB::table('lines')
            ->join('line_sector', 'lines.id', '=', 'line_sector.line_id')
            ->where('sector_id', $sector_id)
            ->select('lines.id as line_id', 'lines.name', 'line_sector.sector_id')
            ->orderBy('lines.name')->get();

        $current_sector = DB::table('sectors')->select('id', 'name')
            ->where('id', $sector_id)->first();
        return $this->ifAuthenticated('site.chooseLine')
            ->with([
                'current_sector' => $current_sector,
                'selected_sector_lines' => $selected_sector_lines,
            ]);
    }

    public function favorites()
    {
        $favorites = DB::table('files')
            ->join('favorites', 'files.id', '=', 'favorites.file_id')
            ->select('files.*', 'favorites.user_id', 'favorites.file_id')
            ->where('favorites.user_id', auth()->user()->id);

        $favorite_videos = DB::table('videos')
            ->join('favorite_videos', 'videos.id', '=', 'favorite_videos.video_id')
            ->select('videos.*', 'favorite_videos.user_id', 'favorite_videos.video_id')
            ->where('favorite_videos.user_id', auth()->user()->id);

        $downloaded = DB::table('file_downloads')
            ->join('files', 'file_downloads.file_id', '=', 'files.id')->get();

        $viewed = DB::table('video_views')
            ->join('videos', 'video_views.video_id', '=', 'videos.id')->get();

        return $this->ifAuthenticated('site.favorites')->with([
            'favorites' => $favorites,
            'favorite_videos' => $favorite_videos,
            'downloaded' => $downloaded,
            'viewed' => $viewed,
        ]);

    }

    public function video(string $id)
    {
        $video = DB::table('videos')->where('id', $id)->first();

        $viewed = DB::table('video_views')
            ->join('videos', 'video_views.video_id', '=', 'videos.id')->get();

        if($video) {
            if ($video->status) {
                return $this->ifAuthenticated('site.video')->with([
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
        return $this->redirect('login');
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
                return $this->ifAuthenticated('site.topic')->with([
                    'active_topics' => $active_topics,
                    'current_topic' => $current_topic,
                    'comments_details' => $comments_details,
                ]);
            }
            return abort(404);
        }
        return abort(404);
    }
}
