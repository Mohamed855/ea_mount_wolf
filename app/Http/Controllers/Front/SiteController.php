<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\File;
use App\Models\FileView;
use App\Models\Line;
use App\Models\ManagerLines;
use App\Models\Sector;
use App\Models\Topic;
use App\Models\Video;
use App\Models\VideoView;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    public function drive(string $sector_id, string $line_id)
    {
        if (Auth::check()) {
            if (auth()->user()->role == 2) {
                $manager_lines = ManagerLines::query()->where('user_id', auth()->id())
                    ->where('sector_id', $sector_id)->first();
                if (! $manager_lines || ! in_array($line_id, $manager_lines->lines)) {
                    return redirect()->route('not_authorized');
                }
            }
            elseif (auth()->user()->role == 3) {
                if (! in_array($sector_id, auth()->user()->sectors) || ! in_array($line_id, auth()->user()->lines)) {
                    return redirect()->route('not_authorized');
                }
            }
            return $this->ifAuthenticated('front.drive', [
                'user_files' => File::query()
                    ->where('files.sector_id', $sector_id)
                    ->where('files.line_id', $line_id)
                    ->where('files.status', '=',1),
                'user_videos' => Video::query()
                    ->where('videos.sector_id', $sector_id)
                    ->where('videos.line_id', $line_id)
                    ->where('videos.status', '=',1),
                'user_favorites_files' => File::query()
                    ->join('favorites', 'files.id', '=', 'favorites.file_id')
                    ->select('favorites.file_id as file_id')
                    ->where('favorites.user_id', auth()->id())
                    ->where('files.status', '=',1)
                    ->get(),
                'user_favorites_videos' => Video::query()
                    ->join('favorite_videos', 'videos.id', '=', 'favorite_videos.video_id')
                    ->select('favorite_videos.video_id as video_id')
                    ->where('favorite_videos.user_id', auth()->id())
                    ->where('videos.status', '=',1)
                    ->get(),
                'fileViewed' => FileView::query()
                    ->join('files', 'file_views.file_id', '=', 'files.id')->get(),
                'videoViewed' => VideoView::query()
                    ->join('videos', 'video_views.video_id', '=', 'videos.id')->get(),
            ]);
        }
        return redirect()->route('select-user');
    }
    public function choose_line(string $sector_id)
    {
        $current_sector = Sector::query()->select('id', 'name')->where('id', $sector_id)->first();
        $selected_sector_lines = Line::query()
            ->join('line_sector', 'lines.id', '=', 'line_sector.line_id')
            ->where('sector_id', $sector_id)
            ->where('lines.status', 1)
            ->select('lines.id as line_id', 'lines.name', 'line_sector.sector_id')
            ->orderBy('lines.name');

        if (Auth::check()){
            if (Auth::user()->role != 1) {
                $lineIds = auth()->user()->lines;
                if (Auth::user()->role == 2) {
                    $managerSector = ManagerLines::query()->where('user_id', auth()->id())
                        ->where('sector_id', $sector_id)->first();
                    $lineIds  = $managerSector ? $managerSector->lines : [];
                }
                $selected_sector_lines = $selected_sector_lines->whereIn('lines.id', $lineIds);
            }
        }

        return $this->ifAuthenticated('front.chooseLine', [
                'current_sector' => $current_sector,
                'selected_sector_lines' => $selected_sector_lines->get(),
            ]);
    }

    public function video(string $id)
    {
        $video = Video::query()->where('id', $id)->first();

        $viewed = VideoView::query()
            ->join('videos', 'video_views.video_id', '=', 'videos.id')->get();

        if($video) {
            if ($video->status) {
                return $this->ifAuthenticated('front.video', [
                    'video' => $video,
                    'videoViewed' => $viewed,
                ]);
            }
            return abort(404);
        }
        return abort(404);
    }

    public function brain_box()
    {
        $latest_topic = Topic::query()->latest('id')->first();

        if(Auth::check())
            return redirect()->route('topic', $latest_topic->id);
        return redirect()->route('select-user');
    }

    public function topic(string $id)
    {
        $active_topics = Topic::query()->where('status', 1)->get();
        $current_topic = Topic::query()->where('id', $id)->first();
        $comments_details = Comment::query()
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->join('titles', 'users.title_id', '=', 'titles.id')
            ->select(
                'users.user_name',
                'users.profile_image',
                'comments.id',
                'comments.comment',
                'comments.user_id',
                'titles.name as user_title',
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
    public function managerVideos()
    {
        if (Auth::user()->role == 2) {
            return $this->ifAuthenticated('front.manager.videos.index', [
                'videos' => Video::query()
                    ->join('users', 'videos.user_id', '=', 'users.id')
                    ->join('lines', 'videos.line_id', '=', 'lines.id')
                    ->join('sectors', 'videos.sector_id', '=', 'sectors.id')
                    ->where('videos.user_id', auth()->id())
                    ->select(
                        'videos.*',
                        'users.user_name',
                        'sectors.name as sector_name',
                        'lines.name as line_name',
                    ),
                'videoViewed' => VideoView::query()
                    ->join('videos', 'video_views.video_id', '=', 'videos.id')->get(),
            ]);
        } else {
            abort(404);
        }
    }
    public function createVideo()
    {
        if (Auth::user()->role == 2) {
            return $this->ifAuthenticated('front.manager.videos.create',[
                'sectors' => Sector::query()->whereIn('id', auth()->user()->sectors)->get(),
            ]);
        } else {
            abort(404);
        }
    }
    public function managerFiles()
    {
        if (Auth::user()->role == 2) {
            return $this->ifAuthenticated('front.manager.files.index', [
                'files' => File::query()
                    ->join('users', 'files.user_id', '=', 'users.id')
                    ->join('lines', 'files.line_id', '=', 'lines.id')
                    ->join('sectors', 'files.sector_id', '=', 'sectors.id')
                    ->where('files.user_id', auth()->id())
                    ->select(
                        'files.*',
                        'users.user_name',
                        'sectors.name as sector_name',
                        'lines.name as line_name',
                    ),
                'fileViewed' => FileView::query()
                    ->join('files', 'file_views.file_id', '=', 'files.id')->get(),
            ]);
        } else {
            abort(404);
        }
    }
    public function createFile()
    {
        if (Auth::user()->role == 2) {
            return $this->ifAuthenticated('front.manager.files.create',[
                'sectors' => Sector::query()->whereIn('id', auth()->user()->sectors)->get(),
            ]);
        } else {
            abort(404);
        }
    }
}
