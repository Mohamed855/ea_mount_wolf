@extends('layouts.app')

@section('title', $audio->name)

@section('content')

    @php
        $actionsController = new \App\Http\Controllers\Front\ActionsController();
        $actionsController->viewed_audio($audio->id);
    @endphp

    @include('includes.front.navbar')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="video-box ratio ratio-21x9 mb-5" style="max-height: 150px">
                            <audio controls>
                                <source src="{{ $audio->src }}" type="audio/mp3">
                                Your browser does not support the audio.
                            </audio>
                        </div>
                        <div class="video-info pt-3">
                            <div class="video-caption">
                                <div class="video-title"><h3>{{ $audio->name }}</h3></div>
                                <div class="published">
                                    Published <span>{{ $audio->created_at }}</span>
                                </div>
                            </div>
                            <div class="video-statistics">
                                <div class="video-views">
                                    <img src="{{ asset('storage/images/icons/eye_light.svg') }}" style="max-width: 16px" alt="">
                                    <span class="views-number">{{ $audioViewed->where('audio_id', $audio->id)->count() }}</span>
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
