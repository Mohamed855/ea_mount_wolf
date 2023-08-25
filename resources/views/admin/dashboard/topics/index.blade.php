@extends('layouts.dashboard')

@section('title', 'Topics Details')

@section('dashboard_title')
    Topics Details
    <a href="{{ route('ea_topics.create') }}" class="btn btn-outline-success mx-3">Add New</a>
@endsection

@section('dashboard_content')
    @include('sections.dashboard_filter')
    <table class="table mb-5 bg-white">
        <thead class="bg-light">
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Shared By</th>
            <th>Status</th>
            <th>Comments</th>
            <th>Shared At</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @if(count($topics->get()) > 0)
            @if(isset($_GET['search']))
                @php($topics = $topics->where('topics.title', 'like', '%' . $_GET['search'] . '%'))
            @endif
            @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                @php($topics = $topics->whereDate('topics.created_at', $_GET['date'])->get())
            @else
                @php($topics = $topics->get())
            @endif
            @foreach($topics as $topic)
                <tr>
                    <td><img src="{{ asset('images/topics/' . $topic->image ) }}"
                             style="max-width: 100px; height: 60px;">
                    </td>
                    <td>{{ $topic->title }}</td>
                    <td>{{ $topic->user_name }}</td>
                    <td>
                                            <span
                                                class="{{ $topic->status ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                                {{ $topic->status ? 'Published' : 'Suppressed' }}
                                            </span>
                    </td>
                    <td>{{ $topic->comments_count }}</td>
                    <td>{{ date('d-m-Y, h:m a', strtotime($topic->created_at)) }}</td>
                    <td>
                        <a href="{{ route('ea_topics.edit', $topic->id) }}"
                           class="btn btn-outline-primary btn-sm btn-rounded">
                            Edit
                        </a>
                        <a href="{{ route('topic', $topic->id) }}"
                           class="btn btn-outline-warning btn-sm btn-rounded">
                            View
                        </a>
                        <form action="{{ route('toggle_publish_topic', $topic->id) }}" method="post"
                              class="d-inline">
                            @csrf
                            <button type="submit"
                                    class="{{ $topic->status ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                {{ $topic->status ? 'Suppress' : 'Publish' }}
                            </button>
                        </form>
                        <form action="{{ route('ea_topics.destroy', $topic->id) }}" method="post"
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
