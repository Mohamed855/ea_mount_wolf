<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\FavoriteVideo;
use App\Models\Line;
use App\Models\Sector;
use App\Models\Title;
use App\Models\Video;
use App\Models\VideoLine;
use App\Models\VideoNotification;
use App\Models\VideoView;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class VideosController extends Controller
{
    use GeneralTrait;
    use AuthTrait;
    use PanelRulesTrait;
    use PanelMessagesTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->ifAdmin('admin.panel.videos.index', [
            'videos' => Video::query()
                ->join('users', 'videos.user_id', '=', 'users.id')
                ->select(
                    'videos.*',
                    'users.user_name',
                ),
            'videoViewed' => VideoView::query()
                ->join('videos', 'video_views.video_id', '=', 'videos.id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::check()){
            if(auth()->user()->role == 1 || auth()->user()->role == 2)
                return view('admin.panel.videos.create')->with([
                    'titles' => Title::query()->get(),
                    'sectors' => Sector::query()->get(),
                    'user_sector' => Sector::query()->where('id', '=', auth()->user()->sector_id)->first(),
                ]);
            return redirect()->route('not_authorized');
        } else {
            return redirect()->route('select-user');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->videosRules(), $this->videosMessages());

            if ($validator->fails()) {
                return $this->backWithMessage('error', $validator->errors()->first());
            }

            $randomFileName = Str::random(20) . '.' . $request->file('video')->getClientOriginalExtension();
            $videoPath = $request->file('video')->storeAs('public/videos', $randomFileName);
            $video = new Video();

            $video->name = $request->name;
            $video->src = Storage::url($videoPath);
            $video->user_id = auth()->id();
            $video->status = 1;
            $video->titles = [];
            $video->sectors = [];
            $video->lines = [];

            $video->save();

            $videoTitles = [];
            $videoSectors = [];
            $allVideoLines = [];
            $titleIds = Title::query()->get(['id']);
            $sectorIds = Sector::query()->get(['id']);
            $lineIds = Line::query()->get(['id']);

            foreach ($titleIds as $title) {
                if ($request['t_' . $title->id]) $videoTitles[] = $title->id;
            }
            foreach ($sectorIds as $sector) {
                if ($request['s_' . $sector->id]) {
                    $videoSectors[] = $sector->id;
                    $videoSectorLines = [];
                    foreach ($lineIds as $line) {
                        if ($request['s_' . $sector->id . 'l_' . $line->id]) {
                            $videoSectorLines[] = $line->id;
                            if (! in_array($line->id, $allVideoLines)) {
                                $allVideoLines[] = $line->id;
                            }
                        }
                    }
                    $video_lines = new VideoLine();
                    $video_lines->video_id = $video->id;
                    $video_lines->sector_id = $sector->id;
                    $video_lines->lines = $videoSectorLines;
                    $video_lines->save();
                    unset($videoSectorLines);
                }
            }
            $video->update(['titles' => $videoTitles, 'sectors' => $videoSectors, 'lines' => $allVideoLines]);

            $notification = new VideoNotification;

            foreach ($videoSectors as $sector) {
                foreach ($allVideoLines as $line) {
                    $videoNotification = VideoNotification::query()->where('sector_id', $sector)
                        ->where('line_id', $line)->where('video_id', $video->id)->first();
                    if (! $videoNotification) {
                        $notification->text = auth()->user()->first_name . ' ' . auth()->user()->middle_name . ' added a new file - ' . $request->name;
                        $notification->sector_id = $sector;
                        $notification->line_id = $line;
                        $notification->video_id = $video->id;
                        $notification->save();
                    }
                }
            }

            return redirect()->route('videos.index')->with(['success' => 'Video added successfully']);
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went wrong, please try again later');
        }
    }

    public function viewed_by($id) {
        $video_user_views = VideoView::query()
                ->join('users', 'video_views.user_id', '=', 'users.id')
                ->select(
                    'users.first_name',
                    'users.middle_name',
                    'users.last_name',
                    'users.user_name',
                    'users.role',
                    'video_views.created_at',
                )->where('video_id', $id);
        return $this->ifAdmin('admin.panel.videos.viewed_by')->with([
            'video_user_views' => $video_user_views,
            'video_id' => $id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $video = Video::findOrFail($id);
            $videoPath = str_replace('storage', 'public', $video->src);
            Storage::delete($videoPath);
            $video->delete();

            FavoriteVideo::query()->where('video_id', $id)->delete();
            VideoView::query()->where('video_id', $id)->delete();
            VideoLine::query()->where('video_id', $id)->delete();

            return $this->backWithMessage('success', 'Video has been deleted');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went wrong, please try again later');
        }
    }
}
