@extends('layouts.app')

@section('title', 'Announcement Details')

@section('content')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 pb-5">
                        <p class="d-inline fs-4">
                            Announcements Details
                            <a href="{{ route('announcements.create') }}" class="btn btn-outline-success mx-3">Add New</a>
                        </p>
                    </div>
                    <div class="col-lg-12">
                        <table class="table mb-5 bg-white">
                            <thead class="bg-light">
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Uploaded By</th>
                                <th>Status</th>
                                <th>Uploaded at</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($announcements as $announcement)
                                <tr>
                                    <td><img src="{{ asset('images/announcements/' . $announcement->image ) }}" style="width: 100px; height: 40px;"></td>
                                    <td>{{ $announcement->title }}</td>
                                    <td>{{ $announcement->user_name }}</td>
                                    <td>
                                        <span class="{{ $announcement->status ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                            {{ $announcement->status ? 'Published' : 'Suppressed' }}
                                        </span>
                                    </td>
                                    <td>{{ date('d-m-Y, h:m a', strtotime($announcement->created_at)) }}</td>
                                    <td>
                                        <form action="{{ route('toggle_publish_announcement', $announcement->id) }}" method="post" class="d-inline">
                                            @csrf
                                            <button type="submit" class="{{ $announcement->status ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                                {{ $announcement->status ? 'Suppress' : 'Publish' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('announcements.destroy', $announcement->id) }}" method="post" class="d-inline">
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
