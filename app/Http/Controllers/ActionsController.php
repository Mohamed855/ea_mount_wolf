<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Announcement;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\File;
use App\Models\Topic;
use App\Models\User;
use App\Traits\GeneralTrait;

class ActionsController extends Controller
{
    use GeneralTrait;

    public function addToFavorites($file_id) {
        $favorite = new Favorite();

        $favorite->user_id = auth()->user()->id;
        $favorite->file_id = $file_id;

        $favorite->save();

        return $this->redirect('drive');
    }


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
        $this->deleteFromDB('comments', $id);
        return $this->backWithMessage('deletedSuccessfully', 'Comment has been deleted');
    }

    public function toggle_active($id) {
        $user = User::find($id);
        if($user) {
            $user->activated ? $user->activated = 0 : $user->activated = 1;
            $user->save();
        }
        return $this->redirect('users.index');
    }

    public function toggle_publish_announcement($id) {
        $announcement = Announcement::find($id);
        if($announcement) {
            $announcement->status ? $announcement->status = 0 : $announcement->status = 1;
            $announcement->save();
        }
        return $this->redirect('announcements.index');
    }

    public function toggle_publish_topic($id) {
        $topic = Topic::find($id);
        if($topic) {
            $topic->status ? $topic->status = 0 : $topic->status = 1;
            $topic->save();
        }
        return $this->redirect('ea_topics.index');
    }

    public function toggle_show_file($id) {
        $file = File::find($id);
        if($file) {
            $file->status ? $file->status = 0 : $file->status = 1;
            $file->save();
        }
        return $this->redirect('ea_files.index');
    }

    public function not_authorized() {
        return $this->redirectWithMessage('home','notAuthorized', '');
    }
}
