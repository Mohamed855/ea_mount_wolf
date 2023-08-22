<?php

namespace App\Http\Controllers\Admin\Announcements;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnnouncementsController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->ifAdmin(
            $this->ifAdminAuthenticated('admin.dashboard.announcements.index')
                ->with('announcements', DB::table('announcements')
                    ->join('users', 'announcements.user_id', '=', 'users.id')
                    ->select(
                        'announcements.*',
                        'users.user_name'
                    )->get()
                )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAdmin(
            $this->ifAdminAuthenticated('admin.dashboard.announcements.create')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $announcement_title = str_replace(' ', '', $request->title);
        $announcement_image = $announcement_title . time() . '.' . $request->image->extension();

        $announcement = new Announcement();

        $announcement->title = $request->title;
        $announcement->image = $announcement_image;
        $announcement->user_id = auth()->user()->id;
        $announcement->status = 1;

        $announcement->save();

        $request->image->move(public_path('images/announcements'), $announcement_image);

        return $this->backWithMessage('uploadedSuccessfully', 'Topic Shared Successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('announcements', $id, 'images/announcements/', 'image');
        return $this->backWithMessage('deletedSuccessfully', 'announcement has been deleted');
    }
}
