<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FilesRequest;
use App\Models\File;
use App\Models\FileNotification;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FilesController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

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
                    'downloaded' => DB::table('file_downloads')
                        ->join('files', 'file_downloads.file_id', '=', 'files.id')->get(),
                ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::check()) {
            if (auth()->user()->role == 1 || auth()->user()->role == 2)
                return $this->successView('admin.panel.files.create')->with([
                    'sectors' => DB::table('sectors')->get(),
                    'lines' => DB::table('lines')->get(),
                    'user_sector' => DB::table('sectors')->where('id', '=', auth()->user()->sector_id)->first(),
                ]);
            return $this->redirect('not_authorized');
        } else {
            return $this->redirect('choose-login');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FilesRequest $request)
    {
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

        $request->file->move(asset('files'), $fileName);

        $notification = new FileNotification;

        $notification->text = auth()->user()->first_name . ' ' . auth()->user()->middle_name . ' added a new file - ' . $request->name;
        $notification->sector_id = $request->sector;
        $notification->line_id = $request->line;
        $notification->file_id = DB::table('files')->latest('id')->first()->id;

        $notification->save();

        return $this->backWithMessage('uploadedSuccessfully', 'File Uploaded Successfully');
    }

    public function downloaded_by($id) {
        $file_user_downloads = DB::table('file_downloads')
            ->join('users', 'file_downloads.user_id', '=', 'users.id')
            ->select(
                'users.first_name',
                'users.middle_name',
                'users.last_name',
                'users.user_name',
                'users.created_at',
            )->where('file_id', $id)->get();
        return $this->successView('admin.panel.files.downloaded_by')->with([
            'file_user_downloads' => $file_user_downloads,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('files', $id, 'files/', 'stored_name');
        DB::table('favorites')->where('file_id', $id)->delete();
        DB::table('file_downloads')->where('file_id', $id)->delete();
        return $this->backWithMessage('deletedSuccessfully', 'File has been deleted');
    }
}
