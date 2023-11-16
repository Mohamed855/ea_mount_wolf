<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Models\TopicNotification;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TopicsController extends Controller
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
        return $this->ifAdmin('admin.panel.topics.index', [
                'topics' => DB::table('topics')
                ->join('users', 'topics.user_id', '=', 'users.id')
                ->select(
                    'topics.*',
                    'users.user_name',
                    DB::raw('(SELECT COUNT(*) FROM comments WHERE topic_id = topics.id) AS comments_count'),
                )
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAdmin('admin.panel.topics.create', null);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->topicRules(), $this->topicMessages());

            if ($validator->fails()) {
                return $this->backWithMessage('error', $validator->errors()->first());
            }

            $topic_title = str_replace(' ', '', $request->title);
            $topic_image = $topic_title . time() . '.' . $request->image->extension();

            $topic = new Topic();

            $topic->title = $request->title;
            $topic->description = $request->description;
            $topic->image = $topic_image;
            $topic->user_id = auth()->user()->id;
            $topic->status = 1;

            $topic->save();

            $request->image->storeAs('public/images/topics', $topic_image);
            $request->image->move(public_path('storage/images/topics'), $topic_image);

            $notification = new TopicNotification;

            $notification->text = auth()->user()->first_name . ' ' . auth()->user()->middle_name . ' added a new topic - ' . $request->title;
            $notification->topic_id = DB::table('topics')->latest('id')->first()->id;

            $notification->save();

            return $this->backWithMessage('success', 'Topic Shared Successfully');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        return $this->ifAdmin('admin.panel.topics.edit', [
                'selected_topic' => DB::table('topics')->where('id', '=', $id)->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), $this->topicRules(), $this->topicMessages());

            if ($validator->fails()) {
                return $this->backWithMessage('error', $validator->errors()->first());
            }

            $old_topic_name = DB::table('topics')->select('title')->where('id', $id)->first();

            $storedImage = DB::table('topics')->select('image')->where('id', $id)->first();
            if (file_exists(asset('storage/images/topics/' . $storedImage->image)))
                unlink(asset('storage/images/topics/' . $storedImage->image));

            $topic_title = str_replace(' ', '', $request->title);
            $topic_image = $topic_title . time() . '.' . $request->image->extension();

            DB::table('topics')
                ->where('id', '=', $id)
                ->update([
                    'title' => $request->title,
                    'description' => $request->description,
                    'image' => $topic_image,
                ]);

            $request->image->storeAs('public/images/topics', $topic_image);
            $request->image->move(public_path('storage/images/topics'), $topic_image);

            $old_topic_name->title != $request->title ? $title_updated = 1 : $title_updated = 0;

            $notification = new TopicNotification;

            $notification->text = $title_updated == 1 ?
                auth()->user()->first_name . ' ' . auth()->user()->middle_name . ' updated ' . $old_topic_name->title .' topic to ' . $request->title :
                auth()->user()->first_name . ' ' . auth()->user()->middle_name . ' updated ' . $old_topic_name->title .' topic';
            $notification->topic_id = $id;

            $notification->save();

            return $this->backWithMessage('success', 'Topic saved successfully');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('topics', $id, 'storage/images/topics/', 'image');
        DB::table('comments')->where('topic_id', $id)->delete();
        return $this->backWithMessage('success', 'Topic has been deleted');
    }
}
