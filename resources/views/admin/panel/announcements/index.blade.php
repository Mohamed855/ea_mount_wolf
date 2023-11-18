@extends('layouts.panel')

@section('title', 'Announcement Details')

@section('panel_title')
    Announcement Details
    <a href="{{ route('announcements.create') }}" class="btn btn-outline-success mx-3">Add New</a>
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
    <div class="scroll-bar">
        <table class="table bg-white">
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
                @if(count($announcements) > 0)
                    @foreach($announcements as $announcement)
                        <tr>
                            <td><img src="{{ asset('storage/images/announcements/' . $announcement->image ) }}"
                                     style="width: 100px; height: 40px;"></td>
                            <td>{{ $announcement->title }}</td>
                            <td>{{ ucfirst($announcement->user_name) }}</td>
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
                    @include('includes.admin.empty_message')
                @endif
            @else
                @include('includes.admin.empty_message')
            @endif
            </tbody>
        </table>
    </div>
@endsection
