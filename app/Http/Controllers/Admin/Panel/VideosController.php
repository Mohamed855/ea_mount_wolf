<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\FavoriteVideo;
use App\Models\Sector;
use App\Models\Video;
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
                ->join('lines', 'videos.line_id', '=', 'lines.id')
                ->join('sectors', 'videos.sector_id', '=', 'sectors.id')
                ->select(
                    'videos.*',
                    'users.user_name',
                    'sectors.name as sector_name',
                    'lines.name as line_name',
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
            $video->sector_id = $request->sector;
            $video->line_id = $request->line;
            $video->user_id = auth()->id();
            $video->status = 1;

            $video->save();

            $notification = new VideoNotification;

            $notification->text = auth()->user()->first_name . ' ' . auth()->user()->middle_name . ' added a new video - ' . $request->name;
            $notification->sector_id = $request->sector;
            $notification->line_id = $request->line;
            $notification->video_id = $video->id;

            $notification->save();

            return $this->backWithMessage('success', 'Video added successfully');
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
                    'users.created_at',
                )->where('video_id', $id)->get();
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

            return $this->backWithMessage('success', 'Video has been deleted');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went wrong, please try again later');
        }
    }
}
