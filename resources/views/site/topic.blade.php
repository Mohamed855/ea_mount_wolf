@extends('layouts.app')

@section($current_topic->title, 'Employee Access - Brain Box')

@section('content')

    @include('sections.nav')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="brain-box-title">
                            <h2 class="text-center">
                                {{ $current_topic->title }}
                            </h2>

                        </div>
                        <div class="brain-box ratio ratio-16x9" style="background-image: url({{ asset('images/topics/'.$current_topic->image) }})">
                        </div>

                        <h5 class="text-center lh-lg pb-5 text-dark">
                            {{ $current_topic->description == null ? '' : $current_topic->description }}
                        </h5>

                        <div class="comments-section brain-box-comments">
                            @foreach($comments_details as $comment_details)
                                <div class="comment-box">
                                    <div class="comment-info">
                                        <div class="prof-pic bg-styles"  style="background-image:url({{
                                    $comment_details->profile_image == null ?
                                    asset('images/profile_images/default_profile_image.jpg') :
                                    asset('images/profile_images/'.$comment_details->profile_image)
                                 }}); max-width: 50px; max-height: 50px">
                                        </div>
                                        <div class="comment-name">{{ $comment_details->user_name }}</div>
                                        <div class="comment-title">{{ $comment_details->user_title . ' - ' . $comment_details->user_sector .  ' - ' . $comment_details->user_line }}</div>
                                    </div>
                                    <div class="comment-txt">
                                        <p>{{ $comment_details->comment }}</p>
                                    </div>
                                    @if($comment_details->user_id === auth()->user()->id || auth()->user()->sector_id == 1)
                                        <form action="{{ route('delete_comment', $comment_details->id) }}" method="post" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-rounded">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                            <form action="{{ route('post_comment') }}" method="post">
                                @csrf
                                <div class="comment-box write-comment">
                                    <div class="comment-info">
                                        <div class="prof-pic bg-styles" style="background-image:url({{
                                            $user_details->profile_image == null ?
                                            asset('images/profile_images/default_profile_image.jpg') :
                                            asset('images/profile_images/'.$user_details->profile_image)
                                         }}); max-width: 50px; max-height: 50px">
                                        </div>
                                        <h6 class="pt-1 comment-name">{{ $user_details->user_name }}</h6>
                                        <h6 class="comment-title">{{ $user_details->title_name . ' - ' . $user_details->sector_name . ' - ' . $user_details->line_name }}</h6>
                                    </div>
                                    <div class="comment-txt">
                                        <div class="input-group mb-3">
                                            <input type="hidden" name="topic" value="{{ $current_topic->id }}">
                                            <textarea type="text" class="form-control" placeholder="Write a comment.." aria-label="Write a comment.." aria-describedby="button-addon2"  style="min-height: 100px" name="comment"></textarea>
                                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><img src="{{ asset('images/icons/send.png') }}" style="max-width: 20px"></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="related-topics">
                            <h3 class="text-start">Related Topics:</h3>
                            <div class="scrollmenu">
                                @foreach($active_topics as $topic)
                                    @if($topic->id != $current_topic->id)
                                        <a href="{{ route('topic', $topic->id) }}">
                                            <div class="topic-box" style="background-image: url({{ asset('images/topics/' . $topic->image) }})">
                                                {{ $topic->title }}
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('sections.footer')
    </div>

    @include('sections.scripts')

    <script src="{{ asset('assets/js/owl.carousel.js') }}"></script>
    <script>
        $(document).ready(function(){
            $("#topics-carousel").owlCarousel({
                margin:30,
                autoplay:true,
                loop:true,
                autoplayHoverPause:true,
                responsive:{ 0:{items:2,}, 600:{items:3,}, 1000:{items:4,} }
            });
        });
    </script>

@endsection
