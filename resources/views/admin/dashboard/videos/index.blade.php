@extends('layouts.dashboard')

@section('title', 'Videos Details')

@section('dashboard_title')
    Videos Details
    <a href="{{ route('videos.create') }}" class="btn btn-outline-success mx-3">Add New</a>
@endsection

@section('dashboard_content')
    @include('sections.dashboard_filter')
    <table class="table mb-5 bg-white">
        <thead class="bg-light">
        <tr>
            <th>Name</th>
            <th>Youtube link</th>
            <th>Uploaded By</th>
            <th>Sector | Line</th>
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
            @foreach($videos as $video)
                <tr>
                    <td>
                        <span>{{ $video->name}}</span>
                    </td>
                    <td>{{ 'https://www.youtube.com/embed/' . $video->src }}</td>
                    <td>{{ $video->user_name }}</td>
                    <td>
                        <span>{{ $video->sector_name . " | " }}</span>
                        <span>{{ $video->line_name }}</span>
                    </td>
                    <td>{{ $viewed->where('video_id', $video->id)->count() }}</td>
                    <td>{{ date('d-m-Y, h:m a', strtotime($video->created_at)) }}</td>
                    <td>
                        <a href="{{ route('viewed_by', $video->id) }}"
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
            <tr>
                <td colspan="7">There is no Topics</td>
            </tr>
        @endif
        </tbody>
    </table>
@endsection
