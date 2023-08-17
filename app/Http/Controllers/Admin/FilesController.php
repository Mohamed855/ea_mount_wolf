<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FilesController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->ifAuthorized(
            $this->ifAuthenticated('site.files.index')
                ->with('files', DB::table('files')
                    ->join('users', 'files.user_id', '=', 'users.id')
                    ->join('lines', 'files.line_id', '=', 'lines.id')
                    ->join('sectors', 'files.sector_id', '=', 'sectors.id')
                    ->select(
                        'files.*',
                        'users.user_name',
                        'sectors.name as sector_name',
                        'lines.name as line_name',
                    )->get()
                )
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(auth()->user()->role == 1)
            return $this->ifAuthenticated('site.files.create')->with([
                'sectors' => DB::table('sectors')->get(),
                'lines' => DB::table('lines')->get(),
                'user_sector' => DB::table('sectors')->where('id', '=', auth()->user()->sector_id)->first(),
            ]);
        return $this->redirect('not_authorized');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        $request->file->move(public_path('files'), $fileName);

        return $this->backWithMessage('uploadedSuccessfully', 'File Uploaded Successfully');
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
        $this->deleteFromDB('files', $id, 'files/', 'stored_name');
        return $this->backWithMessage('deletedSuccessfully', 'File has been deleted');
    }
}