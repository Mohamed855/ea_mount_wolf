@extends('layouts.app')

@section('title', 'Videos Details')

@section('content')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 pb-5">
                        <p class="d-inline fs-4">
                            Videos Details
                            <a href="{{ route('videos.create') }}" class="btn btn-outline-success mx-3">Add New</a>
                        </p>
                    </div>
                    <div class="col-lg-12">
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
                                    <td>{{ $video->viewed }}</td>
                                    <td>{{ date('d-m-Y, h:m a', strtotime($video->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('video', $video->id) }}" class="btn btn-outline-warning btn-sm btn-rounded">
                                            View
                                        </a>
                                        <form action="{{ route('toggle_show_video', $video->id) }}" method="post" class="d-inline">
                                            @csrf
                                            <button type="submit" class="{{ $video->status ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                                {{ $video->status ? 'Hide' : 'Show' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('videos.destroy', $video->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm btn-rounded">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
