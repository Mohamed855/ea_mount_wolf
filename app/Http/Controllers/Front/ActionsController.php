<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\CommentNotification;
use App\Models\File;
use App\Models\FileDownload;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoView;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;


class ActionsController extends Controller
{
    use GeneralTrait;

    public function post_comment(CommentRequest $request) {
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
        return $this->backWithMessage('deletedSuccessfully', 'Comment has been deleted');
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
        $file_download = new FileDownload();
        if (!FileDownload::where('user_id', auth()->user()->id)->where('file_id', $id)->exists()) {
            $file_download->user_id = auth()->user()->id;
            $file_download->file_id = $id;
            $file_download->save();
        }
        $file = DB::table('files')->where('id', $id)->first();
        $public_file_name ='files/' . $file->stored_name;
        $headers = array('Content-Type: ' . $file->type,);
        return response()->download(public_path('storage/' . $public_file_name), $file->stored_name, $headers);
    }
    public function view_file($id)
    {
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
    public function not_authorized() {
        return $this->redirect('home')->with('notAuthorized', '');
    }
}
