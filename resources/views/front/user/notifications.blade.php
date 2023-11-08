@extends('layouts.app')

@section('title', auth()->user()->first_name . '\'s notifications')

@section('content')

    @include('includes.front.nav')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="col-6 m-auto scroll-bar">
                            @foreach($registration_notifications as $registration_notification)
                                <a class="notification_item" href="{{ route('users.index') }}">
                                    <div class="comment-box">
                                        <div class="comment-txt">
                                            <p>{{ $registration_notification->text }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                            @foreach($comment_notifications as $comment_notification)
                                <a class="notification_item" href="{{ route('topic', $comment_notification->topic_id) }}">
                                    <div class="comment-box">
                                        <div class="comment-txt">
                                            <p>{{ $comment_notification->text }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                            @foreach($video_notifications as $video_notification)
                                <a class="notification_item" href="{{ route('video', $video_notification->video_id) }}">
                                    <div class="comment-box">
                                        <div class="comment-txt">
                                            <p>{{ $video_notification->text }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                            @foreach($file_notifications as $file_notification)
                                <a class="notification_item" href="{{ route('file.view', $file_notification->file_id) }}">
                                    <div class="comment-box">
                                        <div class="comment-txt">
                                            <p>{{ $file_notification->text }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                            @foreach($topic_notifications as $topic_notification)
                                <a class="notification_item" href="{{ route('topic', $topic_notification->topic_id) }}">
                                    <div class="comment-box">
                                        <div class="comment-txt">
                                            <p>{{ $topic_notification->text }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.front.footer')
    </div>

    @include('includes.front.scripts')

    <script>
        document.getElementById('profile_picture').addEventListener('change', function() {
            document.getElementById('profile_picture_form').submit();
        });
    </script>

@endsection
