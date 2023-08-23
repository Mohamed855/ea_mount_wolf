<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\File;
use App\Models\User;
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
    public function download_file($id) {
        $file = DB::table('files')->where('id', $id)->first();
        $public_file_name ='files/' . $file->stored_name;
        $headers = array('Content-Type: ' . $file->type,);
        return response()->download(public_path($public_file_name), $file->stored_name, $headers);
    }
    public function not_authorized() {
        return $this->redirectWithMessage('home','notAuthorized', '');
    }
}
