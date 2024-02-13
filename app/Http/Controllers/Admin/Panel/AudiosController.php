<?php

namespace App\Http\Controllers\Admin\Panel;

use App\Http\Controllers\Controller;
use App\Models\FavoriteAudio;
use App\Models\Line;
use App\Models\Sector;
use App\Models\Title;
use App\Models\Audio;
use App\Models\AudioLine;
use App\Models\AudioNotification;
use App\Models\AudioView;
use App\Traits\AuthTrait;
use App\Traits\GeneralTrait;
use App\Traits\Messages\PanelMessagesTrait;
use App\Traits\Rules\PanelRulesTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AudiosController extends Controller
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
        return $this->ifAdmin('admin.panel.audios.index', [
            'audios' => Audio::query()
                ->join('users', 'audios.user_id', '=', 'users.id')
                ->select(
                    'audios.*',
                    'users.user_name',
                ),
            'audioViewed' => AudioView::query()
                ->join('audios', 'audio_views.audio_id', '=', 'audios.id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::check()){
            if(auth()->user()->role == 1 || auth()->user()->role == 2)
                return view('admin.panel.audios.create')->with([
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
            $validator = Validator::make($request->all(), $this->audiosRules(), $this->audiosMessages());

            if ($validator->fails()) {
                return $this->backWithMessage('error', $validator->errors()->first());
            }

            $randomFileName = Str::random(20) . '.' . $request->file('audio')->getClientOriginalExtension();
            $audioPath = $request->file('audio')->storeAs('public/audios', $randomFileName);
            $audio = new Audio();

            $audio->name = $request->name;
            $audio->src = Storage::url($audioPath);
            $audio->user_id = auth()->id();
            $audio->status = 1;
            $audio->titles = [];
            $audio->sectors = [];
            $audio->lines = [];

            $audio->save();

            $audioTitles = [];
            $audioSectors = [];
            $allAudioLines = [];
            $titleIds = Title::query()->get(['id']);
            $sectorIds = Sector::query()->get(['id']);
            $lineIds = Line::query()->get(['id']);

            foreach ($titleIds as $title) {
                if ($request['t_' . $title->id]) $audioTitles[] = $title->id;
            }
            foreach ($sectorIds as $sector) {
                if ($request['s_' . $sector->id]) {
                    $audioSectors[] = $sector->id;
                    $audioSectorLines = [];
                    foreach ($lineIds as $line) {
                        if ($request['s_' . $sector->id . 'l_' . $line->id]) {
                            $audioSectorLines[] = $line->id;
                            if (! in_array($line->id, $allAudioLines)) {
                                $allAudioLines[] = $line->id;
                            }
                        }
                    }
                    $audio_lines = new AudioLine();
                    $audio_lines->audio_id = $audio->id;
                    $audio_lines->sector_id = $sector->id;
                    $audio_lines->lines = $audioSectorLines;
                    $audio_lines->save();
                    unset($audioSectorLines);
                }
            }
            $audio->update(['titles' => $audioTitles, 'sectors' => $audioSectors, 'lines' => $allAudioLines]);

            $notification = new AudioNotification;

            foreach ($audioSectors as $sector) {
                foreach ($allAudioLines as $line) {
                    $audioNotification = AudioNotification::query()->where('sector_id', $sector)
                        ->where('line_id', $line)->where('audio_id', $audio->id)->first();
                    if (! $audioNotification) {
                        $notification->text = auth()->user()->first_name . ' ' . auth()->user()->middle_name . ' added a new file - ' . $request->name;
                        $notification->sector_id = $sector;
                        $notification->line_id = $line;
                        $notification->audio_id = $audio->id;
                        $notification->save();
                    }
                }
            }

            return redirect()->route('audios.index')->with(['success', 'Audio added successfully']);
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went wrong, please try again later');
        }
    }

    public function viewed_by($id) {
        $audio_user_views = AudioView::query()
                ->join('users', 'audio_views.user_id', '=', 'users.id')
                ->select(
                    'users.first_name',
                    'users.middle_name',
                    'users.last_name',
                    'users.user_name',
                    'users.role',
                    'audio_views.created_at',
                )->where('audio_id', $id);
        return $this->ifAdmin('admin.panel.audios.viewed_by')->with([
            'audio_user_views' => $audio_user_views,
            'audio_id' => $id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $audio = Audio::findOrFail($id);
            $audioPath = str_replace('storage', 'public', $audio->src);
            Storage::delete($audioPath);
            $audio->delete();

            FavoriteAudio::query()->where('audio_id', $id)->delete();
            AudioView::query()->where('audio_id', $id)->delete();
            AudioLine::query()->where('audio_id', $id)->delete();

            return $this->backWithMessage('success', 'Audio has been deleted');
        } catch (\Exception $e) {
            return $this->backWithMessage('error', 'Something went wrong, please try again later');
        }
    }
}
