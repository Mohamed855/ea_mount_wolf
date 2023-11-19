<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\FileNotification;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FilesController extends Controller
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
        return $this->ifAdmin('admin.panel.files.index', [
            'files' => DB::table('files')
                ->join('users', 'files.user_id', '=', 'users.id')
                ->join('lines', 'files.line_id', '=', 'lines.id')
                ->join('sectors', 'files.sector_id', '=', 'sectors.id')
                ->select(
                    'files.*',
                    'users.user_name',
                    'sectors.name as sector_name',
                    'lines.name as line_name',
                ),
            'fileViewed' => DB::table('file_views')
                ->join('files', 'file_views.file_id', '=', 'files.id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::check()) {
            if (auth()->user()->role == 1 || auth()->user()->role == 2)
                return view('admin.panel.files.create')->with([
                    'sectors' => DB::table('sectors')->get(),
                    'user_sector' => DB::table('sectors')->where('id', '=', auth()->user()->sector_id)->first(),
                ]);
            return redirect()->route('not_authorized');
        } else {
            return redirect()->route('select-user');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->filesRules(), $this->filesMessages());

            if ($validator->fails()) {
                return $this->backWithMessage('error', $validator->errors()->first());
            }

            $fileName = str_replace(' ', '', $request->name);
            $fileName .= time() . '.' . $request->file->extension();

            $file = new File();

            $file->name = $request->name;
            $file->type = $request->file->getClientMimeType();
            $file->size = $request->file->getSize();
            $file->sector_id = $request->sector;
            $file->status = 1;
            $file->stored_name = $fileName;
            $file->line_id = $request->line;
            $file->user_id = auth()->user()->id;

            $file->save();

            $request->file->storeAs('public/files', $fileName);
            $request->file->move(public_path('storage/files'), $fileName);

            $notification = new FileNotification;

            $notification->text = auth()->user()->first_name . ' ' . auth()->user()->middle_name . ' added a new file - ' . $request->name;
            $notification->sector_id = $request->sector;
            $notification->line_id = $request->line;
            $notification->file_id = DB::table('files')->latest('id')->first()->id;

            $notification->save();

            return $this->backWithMessage('success', 'File uploaded successfully');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
    }

    public function viewed_by($id) {
        $file_user_views = DB::table('file_views')
            ->join('users', 'file_views.user_id', '=', 'users.id')
            ->select(
                'users.first_name',
                'users.middle_name',
                'users.last_name',
                'users.user_name',
                'users.role',
                'users.created_at',
            )->where('file_id', $id)->get();
        return $this->ifAdmin('admin.panel.files.viewed_by')->with([
            'file_user_views' => $file_user_views,
            'file_id' => $id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('files', $id, 'files/', 'stored_name');
        DB::table('favorites')->where('file_id', $id)->delete();
        DB::table('file_views')->where('file_id', $id)->delete();
        return $this->backWithMessage('success', 'File has been deleted');
    }
}
