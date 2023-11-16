<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentNotification;
use App\Models\File;
use App\Models\FileView;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoView;
use App\Traits\GeneralTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;


class ActionsController extends Controller
{
    use GeneralTrait;

    public function post_comment(Request $request) {
        $comment = new Comment();
        $data = $request->all();

        $comment->user_id = auth()->user()->id;
        $comment->topic_id = $data['topic'];
        $comment->comment =  $data['comment'];

        $comment->save();

        $topic_name = DB::table('topics')->select('title')->where('id', $data['topic'])->first();

        $notification = new CommentNotification;

        $notification->text = auth()->user()->user_name . ' commented on a topic (' . $topic_name->title . ')';
        $notification->sector_id = auth()->user()->sector->id;
        $notification->line_id = auth()->user()->line->id;
        $notification->topic_id = $data['topic'];

        $notification->save();

        return $this->backWithMessage('topic', $data['topic']);
    }
    public function delete_comment(string $id)
    {
        $this->deleteFromDB('comments', $id, null, null);
        return $this->backWithMessage('success', 'Comment has been deleted');
    }
    public function toggle_favorite($id) {
        $current_user = User::find(auth()->user()->id);
        $file = File::find($id);
        $current_user->files()->toggle($file->id);
        return back();
    }
    public function toggle_favorite_videos($id) {
        $current_user = User::find(auth()->user()->id);
        $video = Video::find($id);
        $current_user->videos()->toggle($video->id);
        return back();
    }
    public function download_file($id) {
        if (auth()->user()->role = 1) {
            $file = DB::table('files')->where('id', $id)->first();
            $public_file_name ='files/' . $file->stored_name;
            $headers = array('Content-Type: ' . $file->type,);
            return response()->download(public_path('storage/' . $public_file_name), $file->stored_name, $headers);
        }
        return abort(404);
    }
    public function view_file($id)
    {
        $file_viewed = new FileView();
        if (!FileView::where('user_id', auth()->user()->id)->where('file_id', $id)->exists()) {
            $file_viewed->user_id = auth()->user()->id;
            $file_viewed->file_id = $id;
            $file_viewed->save();
        }
        $file = DB::table('files')->where('id', $id)->first();
        $public_file_name = 'files/' . $file->stored_name;
        $headers = array('Content-Type: ' . $file->type,);
        return response()->file(public_path('storage/' . $public_file_name), $headers);
    }
    public function viewed_video($id) {
        $video_viewed = new VideoView();
        if (!VideoView::where('user_id', auth()->user()->id)->where('video_id', $id)->exists()) {
            $video_viewed->user_id = auth()->user()->id;
            $video_viewed->video_id = $id;
            $video_viewed->save();
        }
    }
    public function download_report($table, $id) {
        if (auth()->user()->role = 1) {
            $fileOrVideo = $table == 'file_views' ? File::query()->find($id) : Video::query()->find($id);
            $data = DB::table($table)
                ->join('users', 'file_views.user_id', '=', 'users.id')
                ->select(
                    'users.first_name',
                    'users.middle_name',
                    'users.last_name',
                    'users.user_name',
                    'users.role',
                    'users.created_at',
                )->where('file_id', $id)->get();
            $pdf = PDF::loadView('admin.panel.files.pdf', compact(['data', 'fileOrVideo']));
            return $pdf->download($fileOrVideo->name . '_views.pdf');
        }
        return abort(404);
    }
    public function not_authorized() {
        return $this->redirect('home')->with('notAuthorized', 'You are not Authorized');
    }
}
