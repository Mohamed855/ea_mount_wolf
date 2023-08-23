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
        return $this->ifAdmin(
            $this->ifAdminAuthenticated('admin.dashboard.videos.index')
                ->with('videos', DB::table('videos')
                    ->join('users', 'videos.user_id', '=', 'users.id')
                    ->join('lines', 'videos.line_id', '=', 'lines.id')
                    ->join('sectors', 'videos.sector_id', '=', 'sectors.id')
                    ->select(
                        'videos.*',
                        'users.user_name',
                        'sectors.name as sector_name',
                        'lines.name as line_name',
                    )->get()
                )
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('videos', $id, null, null);
        //DB::table('favorites')->where('file_id', $id)->delete();
        return $this->backWithMessage('deletedSuccessfully', 'Video has been deleted');
    }
}
