@extends('layouts.app')

@section('title', 'Employee Access - Files')

@section('content')

    @include('includes.front.navbar')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        @include('includes.front.filter')
                        <div class="brain-box-title">
                            <h2 class="text-center">
                                Files
                            </h2>
                        </div>
                        <hr>
                        <div class="content">
                            <div class="row scroll-bar" style="height: auto">
                                @if(count($user_files->get()) > 0)
                                    @if(isset($_GET['from']) && DateTime::createFromFormat('Y-m-d', $_GET['from']))
                                        @php($user_files = $user_files->whereDate('files.created_at', '>=', $_GET['from']))
                                    @endif
                                    @if(isset($_GET['to']) && DateTime::createFromFormat('Y-m-d', $_GET['to']))
                                        @php($user_files = $user_files->whereDate('files.created_at', '<=', $_GET['to']))
                                    @endif
                                    @if(isset($_GET['filter']))
                                        @if($_GET['filter'] === 'name')
                                            @php($user_files = $user_files->orderBy('files.name', 'asc')->get())
                                        @elseif($_GET['filter'] === 'date')
                                            @php($user_files = $user_files->orderBy('files.created_at', 'asc')->get())
                                        @elseif($_GET['filter'] === 'size')
                                            @php($user_files = $user_files->orderBy('files.size', 'asc')->get())
                                        @else
                                            @php($user_files = $user_files->get())
                                        @endif
                                    @else
                                        @php($user_files = $user_files->get())
                                    @endif
                                    @if(count($user_files) > 0)
                                        @foreach($user_files as $file)
                                        <div class="col-6 col-md-4 col-lg-3 py-3">
                                            <div class="incentive-box favorite border pb-3 mb-3">
                                            <span>
                                                <a href="{{ route('favorites.toggle', $file->id) }}">
                                                    <img src="
                                                    {{
                                                        in_array($file->id, $user_favorites_files->pluck('file_id')->toArray())  ?
                                                        asset('storage/images/icons/star.png') :
                                                        asset('storage/images/icons/star_light.png')
                                                    }}" style="max-width: 16px">
                                                </a>
                                            </span>
                                                <a href="{{ route('file.view', $file->id) }}" target="_bluck">
                                                    <div class="incentive-title">{{ $file->name }}</div>
                                                    <div class="incentive-body">
                                                        <div class="incentive-txt">Published<br>{{ $file->created_at }}
                                                        </div>
                                                        <div class="incentive-info-box">
                                                            <div class="incentive-info in-views">
                                                                <img src="{{ asset('storage/images/icons/eye_light.svg') }}"
                                                                     style="max-width: 16px" alt="">
                                                                {{ $fileViewed->where('file_id', $file->id)->count() }}
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
                                                                    src="{{ asset('storage/images/icons/extensions/'.$file_icon) }}"
                                                                    style="max-width: 16px" alt="">
                                                            </div>
                                                            <div class="incentive-info in-comments">
                                                                <img src="{{ asset('storage/images/icons/pen-icon.svg') }}"
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
                                            <p class="fs-4 p-5 text-center">There is no files in this line</p>
                                        </div>
                                    @endif
                                @else
                                    <div class="m-auto">
                                        <p class="fs-4 p-5 text-center">There is no files in this line</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 py-3">
                        <div class="brain-box-title">
                            <h2 class="text-center">
                                Videos
                            </h2>
                        </div>
                        <hr>
                        <div class="content">
                            <div class="row scroll-bar py-3" style="height: auto">
                                @if(count($user_videos->get()) > 0)
                                    @if(isset($_GET['from']) && DateTime::createFromFormat('Y-m-d', $_GET['from']))
                                        @php($user_videos = $user_videos->whereDate('videos.created_at', '>=', $_GET['from']))
                                    @endif
                                    @if(isset($_GET['to']) && DateTime::createFromFormat('Y-m-d', $_GET['to']))
                                        @php($user_videos = $user_videos->whereDate('videos.created_at', '<=', $_GET['to']))
                                    @endif
                                    @if(isset($_GET['filter']))
                                        @if($_GET['filter'] === 'name')
                                            @php($user_videos = $user_videos->orderBy('videos.name', 'asc')->get())
                                        @elseif($_GET['filter'] === 'date')
                                            @php($user_videos = $user_videos->orderBy('videos.created_at', 'asc')->get())
                                        @else
                                            @php($user_videos = $user_videos->get())
                                        @endif
                                    @else
                                        @php($user_videos = $user_videos->get())
                                    @endif
                                    @if(count($user_videos) > 0)
                                        @foreach($user_videos as $video)
                                            <div class="col-6 col-md-4 col-lg-3">
                                            <div class="incentive-box favorite border pb-3 mb-3">
                                            <span>
                                                <a href="{{ route('favorite_videos.toggle', $video->id) }}">
                                                    <img src="
                                                    {{
                                                        in_array($video->id, $user_favorites_videos->pluck('video_id')->toArray())  ?
                                                        asset('storage/images/icons/star.png') :
                                                        asset('storage/images/icons/star_light.png')
                                                    }}" style="max-width: 16px">
                                                </a>
                                            </span>
                                                <a href="{{ route('video', $video->id) }}">
                                                    <div class="incentive-title">{{ $video->name }}</div>
                                                    <div class="incentive-body">
                                                        <div class="incentive-txt">Published<br>{{ $video->created_at }}
                                                        </div>
                                                        <div class="incentive-info-box">
                                                            <div class="incentive-info in-views">
                                                                <img src="{{ asset('storage/images/icons/eye_light.svg') }}"
                                                                     style="max-width: 16px" alt="">
                                                                {{ $videoViewed->where('video_id', $video->id)->count() }}
                                                            </div>
                                                            <div class="incentive-info in-files">
                                                                <img
                                                                    src="{{ asset('storage/images/icons/extensions/video-icon.svg') }}"
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
                                            <p class="fs-4 p-5 text-center">There is no Videos in this line</p>
                                        </div>
                                    @endif
                                @else
                                    <div class="m-auto">
                                        <p class="fs-4 p-5 text-center">There is no Videos in this line</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 py-3">
                        <div class="brain-box-title">
                            <h2 class="text-center">
                                Audios
                            </h2>
                        </div>
                        <hr>
                        <div class="content">
                            <div class="row scroll-bar py-3" style="height: auto">
                                @if(count($user_audios->get()) > 0)
                                    @if(isset($_GET['from']) && DateTime::createFromFormat('Y-m-d', $_GET['from']))
                                        @php($user_audios = $user_audios->whereDate('audios.created_at', '>=', $_GET['from']))
                                    @endif
                                    @if(isset($_GET['to']) && DateTime::createFromFormat('Y-m-d', $_GET['to']))
                                        @php($user_audios = $user_audios->whereDate('audios.created_at', '<=', $_GET['to']))
                                    @endif
                                    @if(isset($_GET['filter']))
                                        @if($_GET['filter'] === 'name')
                                            @php($user_audios = $user_audios->orderBy('audios.name', 'asc')->get())
                                        @elseif($_GET['filter'] === 'date')
                                            @php($user_audios = $user_audios->orderBy('audios.created_at', 'asc')->get())
                                        @else
                                            @php($user_audios = $user_audios->get())
                                        @endif
                                    @else
                                        @php($user_audios = $user_audios->get())
                                    @endif
                                    @if(count($user_audios) > 0)
                                        @foreach($user_audios as $audio)
                                            <div class="col-6 col-md-4 col-lg-3">
                                            <div class="incentive-box favorite border pb-3 mb-3">
                                            <span>
                                                <a href="{{ route('favorite_audios.toggle', $audio->id) }}">
                                                    <img src="
                                                    {{
                                                        in_array($audio->id, $user_favorites_audios->pluck('audio_id')->toArray())  ?
                                                        asset('storage/images/icons/star.png') :
                                                        asset('storage/images/icons/star_light.png')
                                                    }}" style="max-width: 16px">
                                                </a>
                                            </span>
                                                <a href="{{ route('audio', $audio->id) }}">
                                                    <div class="incentive-title">{{ $audio->name }}</div>
                                                    <div class="incentive-body">
                                                        <div class="incentive-txt">Published<br>{{ $audio->created_at }}
                                                        </div>
                                                        <div class="incentive-info-box">
                                                            <div class="incentive-info in-views">
                                                                <img src="{{ asset('storage/images/icons/eye_light.svg') }}"
                                                                     style="max-width: 16px" alt="">
                                                                {{ $audioViewed->where('audio_id', $audio->id)->count() }}
                                                            </div>
                                                            <div class="incentive-info in-files">
                                                                <img
                                                                    src="{{ asset('storage/images/icons/extensions/audio-icon.png') }}"
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
                                            <p class="fs-4 p-5 text-center">There is no Audios in this line</p>
                                        </div>
                                    @endif
                                @else
                                    <div class="m-auto">
                                        <p class="fs-4 p-5 text-center">There is no Audios in this line</p>
                                    </div>
                                @endif
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

    </body>
    <script src="{{ asset('assets/js/custom-select.js') }}"></script>

    <script src="{{ asset('assets//js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
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
