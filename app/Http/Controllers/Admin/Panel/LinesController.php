<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LinesRequest;
use App\Models\Line;
use App\Models\LineSector;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class LinesController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->ifAdmin('admin.panel.lines.index', [
                    'lines' => DB::table('lines'),
                    'countOfEmployees' => DB::table('users')->select('line_id')->get(),
                    'countOfFiles' => DB::table('files')->select('line_id')->get(),
                ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAdmin('admin.panel.lines.create', [
                'sectors' => DB::table('sectors')->get(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LinesRequest $request)
    {
        $lines = new Line();
        $lines->name = $request->name;
        $lines->save();

        $sectors = $request->input('sectors');
        $line_id = Line::latest('id')->first()->id;
        foreach ($sectors as $sector) {
            $line_sector = new LineSector();
            $line_sector->sector_id = $sector;
            $line_sector->line_id = $line_id;
            $line_sector->save();
        }

        return $this->backWithMessage('uploadedSuccessfully', 'Line Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->ifAdmin('admin.panel.lines.edit', [
                'selected_line' => DB::table('lines')->where('id', '=', $id)->first(),
                'sectors' => DB::table('sectors')->get(),
                'selected_sectors' => DB::table('line_sector')->where('line_sector.line_id', '=', $id)->get(),
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LinesRequest $request, string $id)
    {

        DB::table('lines')
            ->where('id', '=', $id)
            ->update([
                'name' => $request->name
            ]);

        $selected_sectors = $request->input('sectors');
        DB::table('line_sector')->where('line_id', $id)->delete();
        foreach ($selected_sectors as $sector) {
            $line_sector = new LineSector();
            $line_sector->sector_id = $sector;
            $line_sector->line_id = $id;
            $line_sector->save();
        }

        return $this->backWithMessage('savedSuccessfully', 'Line saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('lines', $id, null, null);
        DB::table('line_sector')->where('line_id', $id)->delete();
        DB::table('files')->where('line_id', $id)->delete();
        DB::table('videos')->where('line_id', $id)->delete();
        return $this->backWithMessage('deletedSuccessfully', 'Line has been deleted');
    }
}
