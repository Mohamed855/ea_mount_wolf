@extends('layouts.panel')

@section('title', 'Topics Details')

@section('panel_title')
    Topics Details
    <a href="{{ route('ea_topics.create') }}" class="btn btn-outline-success mx-3">Add New</a>
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
                @if(isset($_GET['from']) && DateTime::createFromFormat('Y-m-d', $_GET['from']))
                    @php($topics = $topics->whereDate('topics.created_at', '>=' , $_GET['from']))
                @endif
                @if(isset($_GET['to']) && DateTime::createFromFormat('Y-m-d', $_GET['to']))
                    @php($topics = $topics->whereDate('topics.created_at', '<=' , $_GET['to']))
                @endif
                @php($topics = $topics->get())
                @if(count($topics) > 0)
                    @foreach($topics as $topic)
                        <tr>
                            <td><img src="{{ asset('storage/images/topics/' . $topic->image ) }}"
                                     style="max-width: 100px; height: 60px;">
                            </td>
                            <td>{{ $topic->title }}</td>
                            <td>{{ ucfirst($topic->user_name) }}</td>
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
                    @include('includes.admin.empty_message')
                @endif
            @else
                @include('includes.admin.empty_message')
            @endif
            </tbody>
        </table>
    </div>
@endsection
