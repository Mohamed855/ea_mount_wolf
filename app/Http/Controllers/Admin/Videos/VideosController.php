<?php

namespace App\Http\Controllers\Admin\Videos;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VideosController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = DB::table('videos')
            ->join('users', 'videos.user_id', '=', 'users.id')
            ->join('lines', 'videos.line_id', '=', 'lines.id')
            ->join('sectors', 'videos.sector_id', '=', 'sectors.id')
            ->select(
                'videos.*',
                'users.user_name',
                'sectors.name as sector_name',
                'lines.name as line_name',
            );
        $viewed = DB::table('video_views')
            ->join('videos', 'video_views.video_id', '=', 'videos.id')->get();
        return $this->ifAdmin(
            $this->ifAdminAuthenticated('admin.dashboard.videos.index')
                ->with([
                    'videos' => $videos,
                    'viewed' => $viewed,
                ])
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(auth()->user()->role == 1 || auth()->user()->role == 2)
            return $this->successView('admin.dashboard.videos.create')->with([
                'sectors' => DB::table('sectors')->get(),
                'lines' => DB::table('lines')->get(),
                'user_sector' => DB::table('sectors')->where('id', '=', auth()->user()->sector_id)->first(),
            ]);
        return $this->redirect('not_authorized');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $video = new Video();

        $youtube_url = $request->src;
        parse_str(parse_url($youtube_url, PHP_URL_QUERY), $params);
        $video_id = $params['v'];

        $video->name = $request->name;
        $video->src = $video_id;
        $video->sector_id = $request->sector;
        $video->line_id = $request->line;
        $video->user_id = auth()->user()->id;
        $video->status = 1;

        $video->save();

        return $this->backWithMessage('uploadedSuccessfully', 'Video Added Successfully');
    }

    public function viewed_by($id) {
        $video_user_views = DB::table('video_views')
            ->join('users', 'video_views.user_id', '=', 'users.id')
            ->select(
                'users.first_name',
                'users.middle_name',
                'users.last_name',
                'users.user_name',
                'users.created_at',
            )->where('video_id', $id)->get();
        return $this->successView('admin.dashboard.videos.viewed_by')->with([
            'video_user_views' => $video_user_views,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('videos', $id, null, null);
        DB::table('favorite_videos')->where('video_id', $id)->delete();
        DB::table('video_views')->where('video_id', $id)->delete();
        return $this->backWithMessage('deletedSuccessfully', 'Video has been deleted');
    }
}
