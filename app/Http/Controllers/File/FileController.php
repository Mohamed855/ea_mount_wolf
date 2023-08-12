<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileRequest;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('site.file.index')->with([
            'files' => File::where('line', auth()->user()->line)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('site.file.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FileRequest $request)
    {
        $fileName = $request->name;

        File::create([
            'name' => $fileName,
            'type' => $request->file->getClientMimeType(),
            'size' => $request->file->getSize(),
            'line' => $request->line,
            'user_id' => auth()->user()->id,
        ]);

        $fileName .= time() . '.' . $request->file->extension();
        $request->file->move(public_path('files'), $fileName);

        return redirect()->back()->with([
            'uploadedSuccessfully' => 'File Uploaded Successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('site.file.show') -> with('file', File::where('id', $id)->first());
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
        File::where('id', $id) -> delete();
        return redirect()->back()-> with('deletedSuccessfully', 'File has been deleted');
    }
}
