@extends('layouts.app')

@section('title', 'Employee Access - favorites')

@section('content')

    @include('includes.front.navbar')
    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 py-3">
                        @include('includes.front.filter')
                        <h2 class="text-center">Favorite Files</h2>
                        <hr>
                        <div class="row scroll-bar">
                            @if(count($favorites->get()) > 0)
                                @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                                    @php($favorites = $favorites->whereDate('created_at', $_GET['date']))
                                @endif
                                @if(isset($_GET['filter']))
                                    @if($_GET['filter'] === 'name')
                                        @php($favorites = $favorites->orderBy('files.name', 'asc')->get())
                                    @elseif($_GET['filter'] === 'date')
                                        @php($favorites = $favorites->orderBy('files.created_at', 'asc')->get())
                                    @elseif($_GET['filter'] === 'size')
                                        @php($favorites = $favorites->orderBy('files.size', 'asc')->get())
                                    @else
                                        @php($favorites = $favorites->get())
                                    @endif
                                @else
                                    @php($favorites = $favorites->get())
                                @endif
                                @foreach($favorites as $file)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="incentive-box favorite border pb-3 mb-3">
                                            <span>
                                                <a href="{{ route('favorites.toggle', $file->file_id) }}">
                                                    <img src="{{ public_path('images/icons/star.png') }}"
                                                         style="max-width: 16px">
                                                </a>
                                            </span>
                                            <a href="{{ route('file.view', $file->id) }}">
                                                <div class="incentive-title">{{ $file->name }}</div>
                                                <div class="incentive-body">
                                                    <div class="incentive-txt">Published<br>{{ $file->created_at }}
                                                    </div>
                                                    <div class="incentive-info-box">
                                                        <div class="incentive-info in-views">
                                                            <img src="{{ public_path('images/icons/eye_light.svg') }}"
                                                                 style="max-width: 16px" alt="">
                                                            {{ $downloaded->where('file_id', $file->id)->count() }}
                                                        </div>
                                                        @php($file_icon = "")
                                                        @if (str_contains($file->type, 'word'))
                                                            @php($file_icon = "word-icon.svg")
                                                        @elseif (str_contains($file->type, 'excel'))
                                                            @php($file_icon = "excel-icon.svg")
                                                        @elseif (str_contains($file->type, 'pdf'))
                                                            @php($file_icon = "pdf-icon.svg")
                                                        @elseif (str_contains($file->type, 'zip'))
                                                            @php($file_icon = "zip-icon.svg")
                                                        @elseif (str_contains($file->type, 'jpg') || str_contains($file->type, 'jpeg'))
                                                            @php($file_icon = "jpg-icon.svg")
                                                        @elseif (str_contains($file->type, 'png'))
                                                            @php($file_icon = "png-icon.svg")
                                                        @elseif (str_contains($file->type, 'gif'))
                                                            @php($file_icon = "gif-icon.svg")
                                                        @else
                                                            @php($file_icon = "default-icon.svg")
                                                        @endif
                                                        <div class="incentive-info in-files">
                                                            <img
                                                                src="{{ public_path('images/icons/extensions/'.$file_icon) }}"
                                                                style="max-width: 16px" alt="">
                                                        </div>
                                                        <div class="incentive-info in-comments">
                                                            <img src="{{ public_path('images/icons/pen-icon.svg') }}"
                                                                 style="max-width: 16px" alt="">
                                                            {{ floor($file->size / 1000) < 1000 ?  floor($file->size / 1000) . ' K' :  floor($file->size / 1000 / 1000) . ' Mb' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="m-auto">
                                    <p class="fs-4 p-5 text-center">Add some files to favorites</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-lg-12 py-3">
                            <div class="brain-box-title">
                                <h2 class="text-center">
                                    Favorite Videos
                                </h2>
                            </div>
                            <hr>
                            <div class="content">
                                <div class="row scroll-bar">
                                    @if(count($favorite_videos->get()) > 0)
                                        @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                                            @php($favorite_videos = $favorite_videos->whereDate('created_at', $_GET['date']))
                                        @endif
                                        @if(isset($_GET['filter']))
                                            @if($_GET['filter'] === 'name')
                                                @php($favorite_videos = $favorite_videos->orderBy('videos.name', 'asc')->get())
                                            @elseif($_GET['filter'] === 'date')
                                                @php($favorite_videos = $favorite_videos->orderBy('videos.created_at', 'asc')->get())
                                            @else
                                                @php($favorite_videos = $favorite_videos->get())
                                            @endif
                                        @else
                                            @php($favorite_videos = $favorite_videos->get())
                                        @endif
                                        @foreach($favorite_videos as $video)
                                            <div class="col-6 col-md-4 col-lg-3">
                                                <div class="incentive-box favorite border pb-3 mb-3">
                                            <span>
                                                <a href="{{ route('favorite_videos.toggle', $video->video_id) }}">
                                                    <img src="{{ public_path('images/icons/star.png') }}"
                                                         style="max-width: 16px">
                                                </a>
                                            </span>
                                                    <a href="{{ route('video', $video->id) }}">
                                                        <div class="incentive-title">{{ $video->name }}</div>
                                                        <div class="incentive-body">
                                                            <div class="incentive-txt">
                                                                Published<br>{{ $video->created_at }}</div>
                                                            <div class="incentive-info-box">
                                                                <div class="incentive-info in-views">
                                                                    <img src="{{ public_path('images/icons/eye_light.svg') }}"
                                                                         style="max-width: 16px" alt="">
                                                                    {{ $viewed->where('video_id', $video->id)->count() }}
                                                                </div>
                                                                <div class="incentive-info in-files">
                                                                    <img
                                                                        src="{{ public_path('images/icons/extensions/video-icon.svg') }}"
                                                                        style="max-width: 16px" alt="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="m-auto">
                                            <p class="fs-4 p-5 text-center">
                                                Add some videos to favorites
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.front.footer')
    </div>

    @include('includes.front.scripts')
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('#datepicker').datepicker();
        });
    </script>

    <script src="{{ public_path('assets/js/custom-select.js') }}"></script>
    <script src="{{ public_path('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <script>
        (function ($) {
            $(window).on("load", function () {

                $("a[rel='add-content']").click(function (e) {
                    e.preventDefault();
                    $(".content .mCSB_container p:eq(1)").after("<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>");
                });

                $("a[rel='remove-content']").click(function (e) {
                    e.preventDefault();
                    if ($(".content p").length < 4) {
                        return;
                    }
                    $(".content .mCSB_container hr:last").prev("p").remove();
                });

            });
        })(jQuery);
    </script>
@endsection
