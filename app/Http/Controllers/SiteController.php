<?php

namespace App\Http\Controllers;

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
            ->where('files.status', '=',1)
            ->get();

        $user_favorites_files= DB::table('files')
            ->join('favorites', 'files.id', '=', 'favorites.file_id')
            ->where('favorites.user_id', auth()->user()->id)
            ->where('files.status', '=',1)
            ->get();

        return $this->ifAuthenticated('site.drive')->with([
            'user_files' => $user_files,
            'user_favorites_files' => $user_favorites_files,
        ]);
    }

    public function favorites()
    {
        $favorites = DB::table('files')
            ->join('favorites', 'files.id', '=', 'favorites.file_id')
            ->where('favorites.user_id', auth()->user()->id)
            ->get();

        return $this->ifAuthenticated('site.favorites')->with([
            'favorites' => $favorites,
        ]);

    }

    public function file(string $id)
    {
        $files = DB::table('files')->where('id', $id)->first();

        if($files) {
            if ($files->status) {
                return $this->ifAuthenticated('site.file')->with(
                    'files', $files,
                );
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
