@extends('layouts.panel')

@section('title', 'Audios Details')

@section('panel_title')
    Audios Details
    <a href="{{ route('audios.create') }}" class="btn btn-outline-success mx-3">Add New</a>
@endsection

@section('panel_content')
    @if(session()->has('success'))
        <div class="alert alert-success text-center" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger text-center" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @include('includes.admin.panel_filter')
    <div class="scroll-bar overflow-scroll">
        <table class="table bg-white">
            <thead class="bg-light">
            <tr>
                <th>Name</th>
                <th>Audio</th>
                <th>Uploaded By</th>
                <th>Titles</th>
                <th>Sectors</th>
                <th>Lines</th>
                <th>Viewed</th>
                <th>Uploaded at</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(count($audios->get()) > 0)
                @if(isset($_GET['search']))
                    @php($audios = $audios->where('audios.name', 'like', '%' . $_GET['search'] . '%'))
                @endif
                @if(isset($_GET['from']) && DateTime::createFromFormat('Y-m-d', $_GET['from']))
                    @php($audios = $audios->whereDate('audios.created_at', '>=' , $_GET['from']))
                @endif
                @if(isset($_GET['to']) && DateTime::createFromFormat('Y-m-d', $_GET['to']))
                    @php($audios = $audios->whereDate('audios.created_at', '<=' , $_GET['to']))
                @endif
                @php($audios = $audios->get())
                @if(count($audios) > 0)
                    @foreach($audios as $audio)
                        <tr>
                            <td>
                                <span>{{ $audio->name}}</span>
                            </td>
                            <td>
                                <audio controls>
                                    <source src="{{ $audio->src }}" type="audio/mp3">
                                    Your browser does not support the audio.
                                </audio>
                            </td>
                            <td>{{ ucfirst($audio->user_name) }}</td>
                            <td>
                                @php($audio_titles = \App\Models\Title::query()->whereIn('id', $audio->titles)->get())
                                @if(count($audio_titles) > 0)
                                    <div class="text-start" style="max-height:100px; overflow:auto;">
                                        @for($i = 0; $i < count($audio_titles); $i++)
                                            {{ $i + 1 }} - {{ $audio_titles[$i]->name }}
                                            <br>
                                        @endfor
                                    </div>
                                @else
                                    No titles
                                @endif
                            </td>
                            <td>
                                @php($audio_sectors = \App\Models\Sector::query()->whereIn('id', $audio->sectors)->get())
                                @if(count($audio_sectors) > 0)
                                    <div class="text-start" style="max-height:100px; overflow:auto;">
                                        @for($i = 0; $i < count($audio_sectors); $i++)
                                            {{ $i + 1 }} - {{ $audio_sectors[$i]->name }}
                                            <br>
                                        @endfor
                                    </div>
                                @else
                                    No sectors
                                @endif
                            </td>
                            <td>
                                @php($audio_lines = \App\Models\AudioLine::query()
                                    ->join('sectors as s', 's.id', '=', 'audio_lines.sector_id')
                                    ->where('audio_id', $audio->id)
                                    ->whereIn('sector_id', $audio->sectors)
                                    ->select([
                                        'audio_lines.*',
                                        's.name as sectorName'
                                    ])->get())
                                @if(count($audio_lines) > 0)
                                    <div class="text-start" style="max-height:100px; overflow:auto;">
                                        @php($lines = \App\Models\Line::query()->get())
                                        @for($i = 0; $i < count($audio_lines); $i++)
                                            @php($currentSectorLines = [])
                                            @foreach($lines as $l)
                                                @if(in_array($l->id, $audio_lines[$i]->lines))
                                                    @php($currentSectorLines[] = $l->name)
                                                @endif
                                            @endforeach
                                            <h6>{{ $audio_lines[$i]->sectorName }}</h6>
                                            <p>[{{ implode(', ', $currentSectorLines) }}]</p>
                                        @endfor
                                        @unset($currentSectorLines)
                                    </div>
                                @else
                                    No Lines
                                @endif
                            </td>
                            <td>{{ $audioViewed->where('audio_id', $audio->id)->count() }}</td>
                            <td>{{ date('d-m-Y, h:m a', strtotime($audio->created_at)) }}</td>
                            <td>
                                <a href="{{ route('ea_audios.viewed_by', $audio->id) }}"
                                   class="btn btn-outline-warning btn-sm btn-rounded">
                                    Viewed By
                                </a>
                                <a href="{{ route('audio', $audio->id) }}"
                                   class="btn btn-outline-primary btn-sm btn-rounded">
                                    View
                                </a>
                                <form action="{{ route('toggle_show_audio', $audio->id) }}" method="post"
                                      class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="{{ $audio->status ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                        {{ $audio->status ? 'Hide' : 'Show' }}
                                    </button>
                                </form>
                                <form action="{{ route('audios.destroy', $audio->id) }}" method="post"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm btn-rounded">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    @include('includes.admin.empty_message')
                @endif
            @else
                @include('includes.admin.empty_message')
            @endif
            </tbody>
        </table>
    </div>
@endsection
