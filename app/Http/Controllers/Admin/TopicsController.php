<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopicsController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->ifAuthorized(
            $this->ifAuthenticated('site.topics.index')
            ->with('topics', DB::table('topics')
                ->join('users', 'topics.user_id', '=', 'users.id')
                ->select(
                    'topics.*',
                    'users.user_name',
                    DB::raw('(SELECT COUNT(*) FROM comments WHERE topic_id = topics.id) AS comments_count'),
                )->get()
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAuthorized(
            $this->ifAuthenticated('site.topics.create')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $topic_title = str_replace(' ', '', $request->title);
        $topic_image = $topic_title . time() . '.' . $request->image->extension();

        $topic = new Topic();

        $topic->title = $request->title;
        $topic->description = $request->description;
        $topic->image = $topic_image;
        $topic->user_id = auth()->user()->id;
        $topic->status = 1;

        $topic->save();

        $request->image->move(public_path('images/topics'), $topic_image);

        return $this->backWithMessage('uploadedSuccessfully', 'Topic Shared Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('topics', $id, 'images/topics/', 'image');
        return $this->backWithMessage('deletedSuccessfully', 'Topic has been deleted');
    }
}
