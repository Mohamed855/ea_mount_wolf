@extends('layouts.panel')

@section('title', 'Videos Details')

@section('panel_title')
    Videos Details
    <a href="{{ route('videos.create') }}" class="btn btn-outline-success mx-3">Add New</a>
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
                <th>Video</th>
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
            @if(count($videos->get()) > 0)
                @if(isset($_GET['search']))
                    @php($videos = $videos->where('videos.name', 'like', '%' . $_GET['search'] . '%'))
                @endif
                @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                    @php($videos = $videos->whereDate('videos.created_at', $_GET['date'])->get())
                @else
                    @php($videos = $videos->get())
                @endif
                @if(count($videos) > 0)
                    @foreach($videos as $video)
                        <tr>
                            <td>
                                <span>{{ $video->name}}</span>
                            </td>
                            <td>
                                <video width="200" controls>
                                    <source src="{{ $video->src }}" type="video/mp4">
                                    Your browser does not support the video.
                                </video>
                            </td>
                            <td>{{ ucfirst($video->user_name) }}</td>
                            <td>
                                @php($video_titles = \App\Models\Title::query()->whereIn('id', $video->titles)->get())
                                @if(count($video_titles) > 0)
                                    <div class="text-start" style="max-height:100px; overflow:auto;">
                                        @for($i = 0; $i < count($video_titles); $i++)
                                            {{ $i + 1 }} - {{ $video_titles[$i]->name }}
                                            <br>
                                        @endfor
                                    </div>
                                @else
                                    No titles
                                @endif
                            </td>
                            <td>
                                @php($video_sectors = \App\Models\Sector::query()->whereIn('id', $video->sectors)->get())
                                @if(count($video_sectors) > 0)
                                    <div class="text-start" style="max-height:100px; overflow:auto;">
                                        @for($i = 0; $i < count($video_sectors); $i++)
                                            {{ $i + 1 }} - {{ $video_sectors[$i]->name }}
                                            <br>
                                        @endfor
                                    </div>
                                @else
                                    No sectors
                                @endif
                            </td>
                            <td>
                                @php($video_lines = \App\Models\VideoLine::query()
                                    ->join('sectors as s', 's.id', '=', 'video_lines.sector_id')
                                    ->where('video_id', $video->id)
                                    ->whereIn('sector_id', $video->sectors)
                                    ->select([
                                        'video_lines.*',
                                        's.name as sectorName'
                                    ])->get())
                                @if(count($video_lines) > 0)
                                    <div class="text-start" style="max-height:100px; overflow:auto;">
                                        @php($lines = \App\Models\Line::query()->get())
                                        @for($i = 0; $i < count($video_lines); $i++)
                                            @php($currentSectorLines = [])
                                            @foreach($lines as $l)
                                                @if(in_array($l->id, $video_lines[$i]->lines))
                                                    @php($currentSectorLines[] = $l->name)
                                                @endif
                                            @endforeach
                                            <h6>{{ $video_lines[$i]->sectorName }}</h6>
                                            <p>[{{ implode(', ', $currentSectorLines) }}]</p>
                                        @endfor
                                        @unset($currentSectorLines)
                                    </div>
                                @else
                                    No Lines
                                @endif
                            </td>
                            <td>{{ $videoViewed->where('video_id', $video->id)->count() }}</td>
                            <td>{{ date('d-m-Y, h:m a', strtotime($video->created_at)) }}</td>
                            <td>
                                <a href="{{ route('ea_videos.viewed_by', $video->id) }}"
                                   class="btn btn-outline-warning btn-sm btn-rounded">
                                    Viewed By
                                </a>
                                <a href="{{ route('video', $video->id) }}"
                                   class="btn btn-outline-primary btn-sm btn-rounded">
                                    View
                                </a>
                                <form action="{{ route('toggle_show_video', $video->id) }}" method="post"
                                      class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="{{ $video->status ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                        {{ $video->status ? 'Hide' : 'Show' }}
                                    </button>
                                </form>
                                <form action="{{ route('videos.destroy', $video->id) }}" method="post"
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
