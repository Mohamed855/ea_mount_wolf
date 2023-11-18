<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\Line;
use App\Models\LineSector;
use App\Models\Sector;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectorsController extends Controller
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
        return $this->ifAdmin('admin.panel.sectors.index', [
            'sectors' => Sector::query()->with('line'),
            'countOfFiles' => DB::table('files')->select('sector_id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAdmin('admin.panel.sectors.create', [
            'lines' => DB::table('lines')->where('status', 1)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->sectorsRules(), $this->sectorMessages());

            if ($validator->fails()) {
                return $this->backWithMessage('error', $validator->errors()->first());
            }

            $sectors = new Sector();
            $sectors->name = $request->name;
            $sectors->save();

            $linesIds = Line::query()->get(['id']);
            $sector_id = Sector::latest('id')->first()->id;
            foreach ($linesIds as $line) {
                if ($request['l_' . $line->id]) {
                    $line_sector = new LineSector();
                    $line_sector->line_id = $line->id;
                    $line_sector->sector_id = $sector_id;
                    $line_sector->save();
                }
            }

            return $this->backWithMessage('success', 'Sector created successfully');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return $this->ifAdmin('admin.panel.sectors.edit',[
            'selected_sector' => DB::table('sectors')->where('id', '=', $id)->first(),
            'lines' => DB::table('lines')->where('status', 1)->get(),
            'selected_lines' => DB::table('line_sector')->where('line_sector.sector_id', '=', $id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), $this->sectorsRules(), $this->sectorMessages());

            if ($validator->fails()) {
                return $this->backWithMessage('error', $validator->errors()->first());
            }

            DB::table('sectors')
                ->where('id', '=', $id)
                ->update([
                    'name' => $request->name
                ]);

            $sectorIds = Sector::query()->get(['id']);
            DB::table('line_sector')->where('sector_id', $id)->delete();
            foreach ($sectorIds as $line) {
                if ($request['l_' . $line->id]) {
                    $line_sector = new LineSector();
                    $line_sector->line_id = $line->id;
                    $line_sector->sector_id = $id;
                    $line_sector->save();
                }
            }


            return $this->backWithMessage('success', 'Sector saved successfully');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
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
        return $this->backWithMessage('success', 'Sector has been deleted');
    }
}
