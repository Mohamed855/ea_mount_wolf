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
use App\Models\Audio;
use App\Models\AudioLine;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
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
            'countOfFiles' => File::query()->join('file_lines as fl', 'files.id','fl.file_id')->select('sector_id')->get(),
            'countOfVideos' => Video::query()->join('video_lines as vl', 'videos.id','vl.video_id')->select('sector_id')->get(),
            'countOfAudios' => Audio::query()->join('audio_lines as al', 'audios.id','al.audio_id')->select('sector_id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->ifAdmin('admin.panel.sectors.create', [
            'lines' => Line::query()->where('status', 1)->get(),
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

            return redirect()->route('sectors.index')->with(['success', 'Sector created successfully']);
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
            'selected_sector' => Sector::query()->where('id', '=', $id)->first(),
            'lines' => Line::query()->where('status', 1)->get(),
            'selected_lines' => LineSector::query()->where('line_sector.sector_id', '=', $id)->get(),
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

            Sector::query()->where('id', '=', $id)
                ->update([
                    'name' => $request->name
                ]);

            $sectorIds = Sector::query()->get(['id']);
            LineSector::query()->where('sector_id', $id)->delete();
            foreach ($sectorIds as $line) {
                if ($request['l_' . $line->id]) {
                    $line_sector = new LineSector();
                    $line_sector->line_id = $line->id;
                    $line_sector->sector_id = $id;
                    $line_sector->save();
                }
            }


            return redirect()->route('sectors.index')->with(['success', 'Sector saved successfully']);
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
        LineSector::query()->where('sector_id', $id)->delete();
        FileLine::query()->where('sector_id', $id)->delete();
        VideoLine::query()->where('sector_id', $id)->delete();
        AudioLine::query()->where('sector_id', $id)->delete();
        return $this->backWithMessage('success', 'Sector has been deleted');
    }
}
