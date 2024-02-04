<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentNotification;
use App\Models\File;
use App\Models\FileView;
use App\Models\Topic;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoView;
use App\Models\Audio;
use App\Models\AudioView;
use App\Traits\GeneralTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ActionsController extends Controller
{
    use GeneralTrait;

    public function post_comment(Request $request) {
        $comment = new Comment();
        $data = $request->all();

        $comment->user_id = auth()->id();
        $comment->topic_id = $data['topic'];
        $comment->comment =  $data['comment'];

        $comment->save();

        $topic_name = Topic::query()->select('title')->where('id', $data['topic'])->first();

        $notification = new CommentNotification;

        $notification->text = auth()->user()->user_name . ' commented on a topic (' . $topic_name->title . ')';
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
        $current_user = User::find(auth()->id());
        $file = File::find($id);
        $current_user->files()->toggle($file->id);
        return back();
    }
    public function toggle_favorite_videos($id) {
        $current_user = User::find(auth()->id());
        $video = Video::find($id);
        $current_user->videos()->toggle($video->id);
        return back();
    }
    public function toggle_favorite_audios($id) {
        $current_user = User::find(auth()->id());
        $audio = Audio::find($id);
        $current_user->audios()->toggle($audio->id);
        return back();
    }
    public function download_file($id) {
        if (auth()->user()->role = 1) {
            $file = File::query()->where('id', $id)->first();
            $public_file_name ='files/' . $file->stored_name;
            $headers = array('Content-Type: ' . $file->type,);
            return response()->download(public_path('storage/' . $public_file_name), $file->stored_name, $headers);
        }
        abort(404);
    }
    public function view_file($id)
    {
        $file_viewed = new FileView();
        if (!FileView::where('user_id', auth()->id())->where('file_id', $id)->exists()) {
            $file_viewed->user_id = auth()->id();
            $file_viewed->file_id = $id;
            $file_viewed->save();
        }
        $file = File::query()->findOrFail($id);
        $public_file_name = 'files/' . $file->stored_name;
        $headers = array('Content-Type: ' . $file->type,);
        return response()->file(public_path('storage/' . $public_file_name), $headers);
    }
    public function viewed_video($id) {
        $video_viewed = new VideoView();
        if (!VideoView::where('user_id', auth()->id())->where('video_id', $id)->exists()) {
            $video_viewed->user_id = auth()->id();
            $video_viewed->video_id = $id;
            $video_viewed->save();
        }
    }
    public function viewed_audio($id) {
        $audio_viewed = new AudioView();
        if (!AudioView::where('user_id', auth()->id())->where('audio_id', $id)->exists()) {
            $audio_viewed->user_id = auth()->id();
            $audio_viewed->audio_id = $id;
            $audio_viewed->save();
        }
    }
    public function not_authorized() {
        return redirect()->route('home')->with('notAuthorized', 'You are not Authorized');
    }
    public function downloadCredentials($id) {
        try {
            $userDetails = User::query()->find($id);
            $userPassword = DB::table('passwords')->where('hashed_password', $userDetails['password'])->first();
            $pdf = PDF::loadView('front.auth.credentials', compact(['userDetails', 'userPassword']));
            return $pdf->download($userDetails['first_name'] . '\'s Credentials' . '.pdf');
        } catch (Exception) {
            return back()->with('error', 'Something went wrong');
        }
    }
}
