@extends('layouts.app')

@section('title', auth()->user()->first_name . '\'s profile')

@section('content')

    @include('sections.nav')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="col-6 m-auto">
                            @foreach($registration_notifications as $registration_notification)
                                <div class="">
                                    <div class="">
                                        <p>{{ $registration_notification->text . ' ' . $registration_notification->sector_id . ' ' . $registration_notification->line_id }}</p>
                                    </div>
                                </div>
                            @endforeach
                            @foreach($video_notifications as $video_notification)
                                <div class="comment-box">
                                    <div class="comment-txt">
                                        <p>{{ $video_notification->text . ' ' . $video_notification->sector_id . ' ' . $video_notification->line_id . ' ' . $video_notification->video_id }}</p>
                                    </div>
                                </div>
                            @endforeach
                            @foreach($file_notifications as $file_notification)
                                <div class="comment-box">
                                    <div class="comment-txt">
                                        <p>{{ $file_notification->text . ' ' . $file_notification->sector_id . ' ' . $file_notification->line_id . ' ' . $file_notification->file_id }}</p>
                                    </div>
                                </div>
                            @endforeach
                            @foreach($comment_notifications as $comment_notification)
                                <div class="comment-box">
                                    <div class="comment-txt">
                                        <p>{{ $comment_notification->text . ' ' . $comment_notification->sector_id . ' ' . $comment_notification->line_id . ' ' . $comment_notification->topic_id }}</p>
                                    </div>
                                </div>
                            @endforeach
                            @foreach($topic_notifications as $topic_notification)
                                <div class="comment-box">
                                    <div class="comment-txt">
                                        <p>{{ $topic_notification->text . ' ' . $topic_notification->topic_id }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('sections.footer')
    </div>

    @include('sections.scripts')

    <script>
        document.getElementById('profile_picture').addEventListener('change', function() {
            document.getElementById('profile_picture_form').submit();
        });
    </script>

@endsection
