@extends('layouts.app')

@section('title', $current_topic ? $current_topic->title : 'Empty Topics')

@section('content')

    @include('includes.front.navbar')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        @if($current_topic)
                            <div class="brain-box-title">
                                <h2 class="text-center">
                                    {{ $current_topic ? ucfirst($current_topic->title) : '' }}
                                </h2>
                            </div>
                            <div class="brain-box ratio ratio-16x9 element-bg m-auto my-3"
                                 style="background-image: url({{ asset('storage/images/topics/'.$current_topic->image) }})">
                            </div>

                            <h5 class="text-center lh-lg pb-5 text-dark">
                                {{ $current_topic->description == null ? '' : $current_topic->description }}
                            </h5>

                            <div class="comments-section brain-box-comments">
                                @foreach($comments_details as $comment_details)
                                    <div class="comment-box">
                                        <div class="comment-info">
                                            <div class="prof-pic bg-styles" style="background-image:url({{
                                    $comment_details->user->profile_image == null ?
                                    asset('storage/images/profile_images/default_profile_image.jpg') :
                                    asset('storage/images/profile_images/'.$comment_details->user->profile_image)
                                 }}); max-width: 50px; max-height: 50px">
                                            </div>
                                        </div>
                                        <div class="comment-txt">
                                            <span class="small comment-name">{{ $comment_details->user->role == 1 ? ucfirst($comment_details->user->first_name) : $comment_details->user->title->name . '. ' . ucfirst($comment_details->user->user_name) }}</span>
                                            <p>{{ $comment_details->comment }}</p>
                                        </div>
                                        @if($comment_details->user_id === auth()->id() || auth()->user()->role == 1)
                                            <form action="{{ route('comment.delete', $comment_details->id) }}" method="post"
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-rounded">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endforeach
                                <form action="{{ route('comment.post') }}" method="post">
                                    @csrf
                                    <div class="comment-box write-comment">
                                        <div class="comment-info">
                                            <div class="prof-pic bg-styles" style="background-image:url({{
                                            auth()->user()->profile_image == null ?
                                            asset('storage/images/profile_images/default_profile_image.jpg') :
                                            asset('storage/images/profile_images/'. auth()->user()->profile_image)
                                         }}); max-width: 50px; max-height: 50px">
                                            </div>
                                        </div>
                                        <div class="comment-txt">
                                            <div class="input-group">
                                                <input type="hidden" name="topic" value="{{ $current_topic->id }}">
                                                <textarea type="text" class="form-control py-2" placeholder="Write a comment.."
                                                          aria-label="Write a comment.." aria-describedby="button-addon2"
                                                          style="max-height:65px;resize:none" name="comment"></textarea>
                                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                                                    <img src="{{ asset('storage/images/icons/send.png') }}" style="max-width: 20px">
                                                </button>
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
                                                <div class="topic-box element-bg"
                                                     style="background-image: url({{ asset('storage/images/topics/' . $topic->image) }})">
                                                    {{ $topic->title }}
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="m-auto">
                                <p class="fs-4 p-5 text-center">There is no any Topics yet</p>
                            </div>
                        @endif
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
