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

class LinesController extends Controller
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
        return $this->ifAdmin('admin.panel.lines.index', [
            'lines' => Line::query()->with('sector'),
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
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), $this->lineRules(), $this->lineMessages());

            if ($validator->fails()) {
                return $this->backWithMessage('error', $validator->errors()->first());
            }

            $lines = new Line();
            $lines->name = $request->name;
            $lines->status = 1;
            $lines->save();

            $sectorIds = Sector::query()->get(['id']);
            $line_id = Line::latest('id')->first()->id;
            foreach ($sectorIds as $sector) {
                if ($request['s_' . $sector->id]) {
                    $line_sector = new LineSector();
                    $line_sector->sector_id = $sector->id;
                    $line_sector->line_id = $line_id;
                    $line_sector->save();
                }
            }

            return $this->backWithMessage('success', 'Line created successfully');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
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
    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), $this->lineRules(), $this->lineMessages());

            if ($validator->fails()) {
                return $this->backWithMessage('error', $validator->errors()->first());
            }

            DB::table('lines')
                ->where('id', '=', $id)
                ->update([
                    'name' => $request->name
                ]);

            $sectorIds = Sector::query()->get(['id']);
            DB::table('line_sector')->where('line_id', $id)->delete();
            foreach ($sectorIds as $sector) {
                if ($request['s_' . $sector->id]) {
                    $line_sector = new LineSector();
                    $line_sector->sector_id = $sector->id;
                    $line_sector->line_id = $id;
                    $line_sector->save();
                }
            }

            return $this->backWithMessage('success', 'Line saved successfully');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went error, please try again later');
        }
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
        return $this->backWithMessage('success', 'Line has been deleted');
    }
}
