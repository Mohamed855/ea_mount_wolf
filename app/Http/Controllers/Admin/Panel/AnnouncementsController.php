<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnnouncementsController extends Controller
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
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->announcementRules(), $this->announcementMessages());

            if ($validator->fails()) {
                return $this->backWithMessage('error', $validator->errors()->first());
            }

            $announcement_title = str_replace(' ', '', $request->title);
            $announcement_image = $announcement_title . time() . '.' . $request->image->extension();

            $announcement = new Announcement();

            $announcement->title = $request->title;
            $announcement->image = $announcement_image;
            $announcement->user_id = auth()->user()->id;
            $announcement->status = 1;

            $announcement->save();

            $request->image->storeAs('public/images/announcements', $announcement_image);
            $request->image->move(public_path('storage/images/announcements'), $announcement_image);

            return $this->backWithMessage('success', 'Announcement shared successfully');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('announcements', $id, 'storage/images/announcements/', 'image');
        return $this->backWithMessage('success', 'Announcement has been deleted');
    }
}
