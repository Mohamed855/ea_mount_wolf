@extends('layouts.app')

@section('title', 'Videos Details')

@section('content')

    @include('includes.front.navbar')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="container px-4">
                        @if(session()->has('success'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger text-center" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>

                    <div class="text-center my-5">
                        <p class="d-inline fs-4">
                            Videos Details
                            <a href="{{ route('video.add') }}" class="btn btn-outline-success mx-3">Add New</a>
                        </p>
                    </div>

                    @include('includes.admin.panel_filter')

                    <div class="scroll-bar overflow-scroll">
                        <table class="table bg-white">
                            <thead class="bg-light">
                            <tr>
                                <th>Name</th>
                                <th>Video link</th>
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
                                        <td>{{ ucfirst($video->user_name) }}</td>
                                        <td>
                                            <span>{{ $video->sector_name . " | " }}</span>
                                            <span>{{ $video->line_name }}</span>
                                        </td>
                                        <td>{{ $viewed->where('video_id', $video->id)->count() }}</td>
                                        <td>{{ date('d-m-Y, h:m a', strtotime($video->created_at)) }}</td>
                                        <td>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.front.footer')
    </div>

    @include('includes.front.scripts')

    <script src="{{ asset('assets/js/owl.carousel.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#topics-carousel").owlCarousel({
                margin: 30,
                autoplay: true,
                loop: true,
                autoplayHoverPause: true,
                responsive: {0: {items: 2,}, 600: {items: 3,}, 1000: {items: 4,}}
            });
        });
    </script>
@endsection
