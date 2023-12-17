<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\FileLine;
use App\Models\Line;
use App\Models\LineSector;
use App\Models\Sector;
use App\Models\Video;
use App\Models\VideoLine;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
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
            'countOfFiles' => FileLine::query(),
            'countOfVideos' => VideoLine::query(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAdmin('admin.panel.lines.create', [
                'sectors' => Sector::query()->get(),
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
                'selected_line' => Line::query()->where('id', '=', $id)->first(),
                'sectors' => Sector::query()->get(),
                'selected_sectors' => LineSector::query()->where('line_sector.line_id', '=', $id)->get(),
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

            Line::query()
                ->where('id', '=', $id)
                ->update([
                    'name' => $request->name
                ]);

            $sectorIds = Sector::query()->get(['id']);
            LineSector::query()->where('line_id', $id)->delete();
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
        LineSector::query()->where('line_id', $id)->delete();
        return $this->backWithMessage('success', 'Line has been deleted');
    }
}
