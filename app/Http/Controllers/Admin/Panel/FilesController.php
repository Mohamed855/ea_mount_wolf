<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\File;
use App\Models\FileLine;
use App\Models\FileNotification;
use App\Models\FileView;
use App\Models\Line;
use App\Models\Sector;
use App\Models\Title;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
            'files' => File::query()
                ->join('users', 'files.user_id', '=', 'users.id')
                ->select(
                    'files.*',
                    'users.user_name',
                ),
            'fileViewed' => FileView::query()->join('files', 'file_views.file_id', '=', 'files.id')->get(),
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
                    'titles' => Title::query()->get(),
                    'sectors' => Sector::query()->get(),
                    'user_sector' => Sector::query()->where('id', '=', auth()->user()->sector_id)->first(),
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
            $file->status = 1;
            $file->stored_name = $fileName;
            $file->user_id = auth()->id();
            $file->titles = [];
            $file->sectors = [];
            $file->lines = [];

            $file->save();

            $fileTitles = [];
            $fileSectors = [];
            $allFileLines = [];
            $titleIds = Title::query()->get(['id']);
            $sectorIds = Sector::query()->get(['id']);
            $lineIds = Line::query()->get(['id']);
            foreach ($titleIds as $title) {
                if ($request['t_' . $title->id]) $fileTitles[] = $title->id;
            }
            foreach ($sectorIds as $sector) {
                if ($request['s_' . $sector->id]) {
                    $fileSectors[] = $sector->id;
                    $fileSectorLines = [];
                    foreach ($lineIds as $line) {
                        if ($request['s_' . $sector->id . 'l_' . $line->id]) {
                            $fileSectorLines[] = $line->id;
                            if (! in_array($line->id, $allFileLines)) {
                                $allFileLines[] = $line->id;
                            }
                        }
                    }
                    $file_lines = new FileLine();
                    $file_lines->file_id = $file->id;
                    $file_lines->sector_id = $sector->id;
                    $file_lines->lines = $fileSectorLines;
                    $file_lines->save();
                    unset($fileSectorLines);
                }
            }
            $file->update(['titles' => $fileTitles, 'sectors' => $fileSectors, 'lines' => $allFileLines]);

            $request->file->storeAs('public/files', $fileName);
            $request->file->move(public_path('storage/files'), $fileName);

            $notification = new FileNotification;

            foreach ($fileSectors as $sector) {
                foreach ($allFileLines as $line) {
                    $fileNotification = FileNotification::query()->where('sector_id', $sector)
                        ->where('line_id', $line)->where('file_id', $file->id)->first();
                    if (! $fileNotification) {
                        $notification->text = auth()->user()->first_name . ' ' . auth()->user()->middle_name . ' added a new file - ' . $request->name;
                        $notification->sector_id = $sector;
                        $notification->line_id = $line;
                        $notification->file_id = $file->id;
                        $notification->save();
                    }
                }
            }

            return $this->backWithMessage('success', 'File uploaded successfully');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
    }

    public function viewed_by($id) {
        $file_user_views = FileView::query()->join('users', 'file_views.user_id', '=', 'users.id')
            ->select(
                'users.first_name',
                'users.middle_name',
                'users.last_name',
                'users.user_name',
                'users.role',
                'file_views.created_at',
            )->where('file_id', $id);
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
        Favorite::query()->where('file_id', $id)->delete();
        FileView::query()->where('file_id', $id)->delete();
        FileLine::query()->where('file_id', $id)->delete();
        return $this->backWithMessage('success', 'File has been deleted');
    }
}
