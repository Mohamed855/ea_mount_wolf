@extends('layouts.app')

@section('title', $video->name)

@section('content')

    @php
        $actionsController = new \App\Http\Controllers\Front\ActionsController();
        $actionsController->viewed_video($video->id);
    @endphp

    @include('includes.front.navbar')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="video-box ratio ratio-16x9">
                            <iframe src="{{ 'https://www.youtube.com/embed/' . $video->src }}"
                                    title="YouTube video player" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen></iframe>
                        </div>
                        <div class="video-info pt-3">
                            <div class="video-caption">
                                <div class="video-title"><h3>{{ $video->name }}</h3></div>
                                <div class="published">
                                    Published <span>{{ $video->created_at }}</span>
                                </div>
                            </div>
                            <div class="video-statistics">
                                <div class="video-views">
                                    <img src="{{ asset('storage/images/icons/eye_light.svg') }}" style="max-width: 16px" alt="">
                                    <span
                                            class="views-number">{{ $viewed->where('video_id', $video->id)->count() }}</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="comments-section">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.front.footer')
    </div>
    @include('includes.front.scripts')
@endsection
