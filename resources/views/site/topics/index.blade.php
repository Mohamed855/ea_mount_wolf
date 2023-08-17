@extends('layouts.app')

@section('title', 'Topics Details')

@section('content')
    @include('sections.nav')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 pb-5">
                        <p class="d-inline fs-4">
                            Topics Details
                            <a href="{{ route('ea_topics.create') }}" class="btn btn-success mx-3">Add New</a>
                        </p>
                    </div>
                    <div class="col-lg-12">
                        <table class="table mb-0 bg-white">
                            <thead class="bg-light">
                            <tr>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Shared By</th>
                                <th>Status</th>
                                <th>Comments</th>
                                <th>Shared At</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($topics as $topic)
                                <tr>
                                    <td>{{ $topic->title }}</td>
                                    <td><img src="{{ asset('images/topics/' . $topic->image ) }}" style="max-width: 100px"></td>
                                    <td>{{ $topic->user_name }}</td>
                                    <td>
                                        <span class="{{ $topic->status ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                            {{ $topic->status ? 'Published' : 'Suppressed' }}
                                        </span>
                                    </td>
                                    <td>{{ $topic->comments_count }}</td>
                                    <td>{{ date('d-m-Y, h:m a', strtotime($topic->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('topic', $topic->id) }}" class="btn btn-outline-primary btn-sm btn-rounded">
                                            View
                                        </a>
                                        <form action="{{ route('toggle_publish', $topic->id) }}" method="post" class="d-inline">
                                            @csrf
                                            <button type="submit" class="{{ $topic->status ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                                {{ $topic->status ? 'Suppress' : 'Publish' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('ea_topics.destroy', $topic->id) }}" method="post" class="d-inline">
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
