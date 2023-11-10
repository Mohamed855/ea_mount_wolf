<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnnouncementsRequest;
use App\Models\Announcement;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class AnnouncementsController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->ifAdmin('admin.panel.announcements.index',[
            'announcements' => DB::table('announcements')
                ->join('users', 'announcements.user_id', '=', 'users.id')
                ->select(
                    'announcements.*',
                    'users.user_name'
                )
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAdmin('admin.panel.announcements.create', null);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnnouncementsRequest $request)
    {
        $announcement_title = str_replace(' ', '', $request->title);
        $announcement_image = $announcement_title . time() . '.' . $request->image->extension();

        $announcement = new Announcement();

        $announcement->title = $request->title;
        $announcement->image = $announcement_image;
        $announcement->user_id = auth()->user()->id;
        $announcement->status = 1;

        $announcement->save();

        $request->image->storeAs('public/images/announcements', $announcement_image);

        return $this->backWithMessage('uploadedSuccessfully', 'Topic Shared Successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('announcements', $id, 'storage/images/announcements/', 'image');
        return $this->backWithMessage('deletedSuccessfully', 'announcement has been deleted');
    }
}
