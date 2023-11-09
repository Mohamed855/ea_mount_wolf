<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SectorsRequest;
use App\Models\LineSector;
use App\Models\Sector;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class SectorsController extends Controller
{
    use GeneralTrait;
    use AuthTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->ifAdmin('admin.panel.sectors.index', [
            'sectors' => Sector::query()->with('line'),
            'countOfEmployees' => DB::table('users')->select('sector_id')->get(),
            'countOfFiles' => DB::table('files')->select('sector_id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAdmin('admin.panel.sectors.create', [
            'lines' => DB::table('lines')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectorsRequest $request)
    {
        $sectors = new Sector();
        $sectors->name = $request->name;
        $sectors->save();

        $lines = $request->input('lines');
        $sector_id = Sector::latest('id')->first()->id;
        foreach ($lines as $line) {
            $line_sector = new LineSector();
            $line_sector->line_id = $line;
            $line_sector->sector_id = $sector_id;
            $line_sector->save();
        }

        return $this->backWithMessage('uploadedSuccessfully', 'Sector Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->ifAdmin('admin.panel.sectors.edit',[
            'selected_sector' => DB::table('sectors')->where('id', '=', $id)->first(),
            'lines' => DB::table('lines')->get(),
            'selected_lines' => DB::table('line_sector')->where('line_sector.sector_id', '=', $id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectorsRequest $request, string $id)
    {
        DB::table('sectors')
            ->where('id', '=', $id)
            ->update([
                'name' => $request->name
            ]);

        $selected_lines = $request->input('lines');
        DB::table('line_sector')->where('sector_id', $id)->delete();
        foreach ($selected_lines as $line) {
            $line_sector = new LineSector();
            $line_sector->line_id = $line;
            $line_sector->sector_id = $id;
            $line_sector->save();
        }

        return $this->backWithMessage('savedSuccessfully', 'Sector saved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->deleteFromDB('sectors', $id, null, null);
        DB::table('line_sector')->where('sector_id', $id)->delete();
        DB::table('files')->where('sector_id', $id)->delete();
        DB::table('videos')->where('sector_id', $id)->delete();
        return $this->backWithMessage('deletedSuccessfully', 'Sector has been deleted');
    }
}
