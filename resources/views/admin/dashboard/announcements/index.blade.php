@extends('layouts.dashboard')

@section('title', 'Announcement Details')

@section('dashboard_title')
    Announcement Details
    <a href="{{ route('announcements.create') }}" class="btn btn-outline-success mx-3">Add New</a>
@endsection

@section('dashboard_content')
    @include('sections.dashboard_filter')
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
            @if(count($announcements->get()) > 0)
                @if(isset($_GET['search']))
                    @php($announcements = $announcements->where('announcements.title', 'like', '%' . $_GET['search'] . '%'))
                @endif
                @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                    @php($announcements = $announcements->whereDate('announcements.created_at', $_GET['date'])->get())
                @else
                    @php($announcements = $announcements->get())
                @endif
                @foreach($announcements as $announcement)
                    <tr>
                        <td><img src="{{ asset('images/announcements/' . $announcement->image ) }}"
                                 style="width: 100px; height: 40px;"></td>
                        <td>{{ $announcement->title }}</td>
                        <td>{{ $announcement->user_name }}</td>
                        <td>
                            <span
                                class="{{ $announcement->status ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                {{ $announcement->status ? 'Published' : 'Suppressed' }}
                            </span>
                        </td>
                        <td>{{ date('d-m-Y, h:m a', strtotime($announcement->created_at)) }}</td>
                        <td>
                            <form action="{{ route('toggle_publish_announcement', $announcement->id) }}"
                                  method="post" class="d-inline">
                                @csrf
                                <button type="submit"
                                        class="{{ $announcement->status ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                    {{ $announcement->status ? 'Suppress' : 'Publish' }}
                                </button>
                            </form>
                            <form action="{{ route('announcements.destroy', $announcement->id) }}"
                                  method="post" class="d-inline">
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
                    <td colspan="6">There is no Announcements</td>
                </tr>
            @endif
            </tbody>
        </table>
@endsection
