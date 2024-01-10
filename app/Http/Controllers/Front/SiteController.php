<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\File;
use App\Models\FileView;
use App\Models\Line;
use App\Models\Sector;
use App\Models\Title;
use App\Models\Topic;
use App\Models\Video;
use App\Models\VideoView;
use App\Models\Audio;
use App\Models\AudioView;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

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
                /*if (Auth::user()->role == 2) {
                    $managerSector = ManagerLines::query()->where('user_id', auth()->id())
                        ->where('sector_id', $sector_id)->first();
                    $lineIds  = $managerSector ? $managerSector->lines : [];
                }*/
                $selected_sector_lines = $selected_sector_lines->whereIn('lines.id', $lineIds);
            }
        }

        return $this->ifAuthenticated('front.chooseLine', [
            'current_sector' => $current_sector,
            'selected_sector_lines' => $selected_sector_lines->get(),
        ]);
    }
    public function drive(string $sector_id, string $line_id)
    {
        if (Auth::check()) {
            /*if (auth()->user()->role == 2) {
                $manager_lines = ManagerLines::query()->where('user_id', auth()->id())
                    ->where('sector_id', $sector_id)->first();
                if (! $manager_lines || ! in_array($line_id, $manager_lines->lines)) {
                    return redirect()->route('not_authorized');
                }
            }*/
            if (auth()->user()->role != 1) {
                if (! in_array($line_id, auth()->user()->lines)) {
                    return redirect()->route('not_authorized');
                }
            }

            $userFiles = File::query()->join('file_lines as fl', 'files.id', 'fl.file_id')
                ->where('fl.sector_id', $sector_id)
                ->whereJsonContains('fl.lines', intval($line_id))
                ->where('files.status', '=',1)
                ->select(['files.*', 'fl.file_id', 'fl.sector_id', 'fl.lines']);
            $userVideos = Video::query()->join('video_lines as vl', 'videos.id', 'vl.video_id')
                ->where('vl.sector_id', $sector_id)
                ->whereJsonContains('vl.lines', intval($line_id))
                ->where('videos.status', '=',1)
                ->select(['videos.*', 'vl.video_id', 'vl.sector_id', 'vl.lines']);
            $userAudios = Audio::query()->join('audio_lines as al', 'audios.id', 'al.audio_id')
                ->where('al.sector_id', $sector_id)
                ->whereJsonContains('al.lines', intval($line_id))
                ->where('audios.status', '=',1)
                ->select(['audios.*', 'al.audio_id', 'al.sector_id', 'al.lines']);
            $userFiles = auth()->user()->role == 1 ? $userFiles : $userFiles->whereJsonContains('files.titles', \auth()->user()->title_id);
            $userVideos = auth()->user()->role == 1 ? $userVideos : $userVideos->whereJsonContains('videos.titles', \auth()->user()->title_id);
            $userAudios = auth()->user()->role == 1 ? $userAudios : $userAudios->whereJsonContains('audios.titles', \auth()->user()->title_id);

            return $this->ifAuthenticated('front.drive', [
                'user_files' => $userFiles,
                'user_videos' => $userVideos,
                'user_audios' => $userAudios,
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
                'user_favorites_audios' => Audio::query()
                    ->join('favorite_audios', 'audios.id', '=', 'favorite_audios.audio_id')
                    ->select('favorite_audios.audio_id as audio_id')
                    ->where('favorite_audios.user_id', auth()->id())
                    ->where('audios.status', '=',1)
                    ->get(),
                'fileViewed' => FileView::query()
                    ->join('files', 'file_views.file_id', '=', 'files.id')->get(),
                'videoViewed' => VideoView::query()
                    ->join('videos', 'video_views.video_id', '=', 'videos.id')->get(),
                'audioViewed' => AudioView::query()
                    ->join('audios', 'audio_views.audio_id', '=', 'audios.id')->get(),
            ]);
        }
        return redirect()->route('select-user');
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
            abort(404);
        }
        abort(404);
    }

    public function audio(string $id)
    {
        $audio = Audio::query()->where('id', $id)->first();

        $viewed = AudioView::query()
            ->join('audios', 'audio_views.audio_id', '=', 'audios.id')->get();

        if($audio) {
            if ($audio->status) {
                return $this->ifAuthenticated('front.audio', [
                    'audio' => $audio,
                    'audioViewed' => $viewed,
                ]);
            }
            abort(404);
        }
        abort(404);
    }

    public function brain_box()
    {
        $latest_topic = Topic::query()->latest('id')->first();

        if(Auth::check())
            if ($latest_topic) {
                return redirect()->route('topic', $latest_topic->id);
            }
            else {
                return redirect()->route('topic', 0);
            }
        return redirect()->route('select-user');
    }

    public function topic(string $id)
    {
        if ($id != 0) {
            $active_topics = Topic::query()->where('status', 1)->get();
            $current_topic = Topic::query()->where('id', $id)->first();
            $comments_details = Comment::query()->with(['user'])->where('comments.topic_id', $id)->get();

            $topic = Topic::find($id);

            if($topic) {
                if ($topic->status) {
                    return $this->ifAuthenticated('front.topic', [
                        'active_topics' => $active_topics,
                        'current_topic' => $current_topic,
                        'comments_details' => $comments_details,
                    ]);
                }
                abort(404);
            }
            abort(404);
        } else {
            return $this->ifAuthenticated('front.topic', [
                'active_topics' => null,
                'current_topic' => null,
                'comments_details' => null,
            ]);
        }
    }
    public function managerVideos()
    {
        if (Auth::check() && Auth::user()->role == 2) {
            return $this->ifAuthenticated('front.manager.videos.index', [
                'videos' => Video::query()
                    ->join('users', 'videos.user_id', '=', 'users.id')
                    ->where('videos.user_id', auth()->id())
                    ->select(
                        'videos.*',
                        'users.user_name',
                    ),
                'videoViewed' => VideoView::query()
                    ->join('videos', 'video_views.video_id', '=', 'videos.id')->get(),
            ]);
        } else {
            abort(404);
        }
    }
    public function managerAudios()
    {
        if (Auth::check() && Auth::user()->role == 2) {
            return $this->ifAuthenticated('front.manager.audios.index', [
                'audios' => Audio::query()
                    ->join('users', 'audios.user_id', '=', 'users.id')
                    ->where('audios.user_id', auth()->id())
                    ->select(
                        'audios.*',
                        'users.user_name',
                    ),
                'audioViewed' => AudioView::query()
                    ->join('audios', 'audio_views.audio_id', '=', 'audios.id')->get(),
            ]);
        } else {
            abort(404);
        }
    }
    public function createVideo()
    {
        if (Auth::check() && Auth::user()->role == 2) {
            return $this->ifAuthenticated('front.manager.videos.create',[
                'titles' => Title::query()->get(),
                'sectors' => Sector::query()->whereIn('id', auth()->user()->sectors)->get(),
            ]);
        } else {
            abort(404);
        }
    }
    public function createAudio()
    {
        if (Auth::check() && Auth::user()->role == 2) {
            return $this->ifAuthenticated('front.manager.audios.create',[
                'titles' => Title::query()->get(),
                'sectors' => Sector::query()->whereIn('id', auth()->user()->sectors)->get(),
            ]);
        } else {
            abort(404);
        }
    }
    public function managerFiles()
    {
        if (Auth::check() && Auth::user()->role == 2) {
            return $this->ifAuthenticated('front.manager.files.index', [
                'files' => File::query()
                    ->join('users', 'files.user_id', '=', 'users.id')
                    ->where('files.user_id', auth()->id())
                    ->select(
                        'files.*',
                        'users.user_name',
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
        if (Auth::check() && Auth::user()->role == 2) {
            return $this->ifAuthenticated('front.manager.files.create',[
                'titles' => Title::query()->get(),
                'sectors' => Sector::query()->whereIn('id', auth()->user()->sectors)->get(),
            ]);
        } else {
            abort(404);
        }
    }
}
