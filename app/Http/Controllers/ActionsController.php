<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Favorite;
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
        return redirect()->route('topic', $data['topic']);
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
        return response()->download(public_path($public_file_name), $file->stored_name, $headers);
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
        return $this->redirectWithMessage('home','notAuthorized', '');
    }
}
