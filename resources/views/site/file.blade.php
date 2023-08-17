@extends('layouts.app')

@section('title', 'show')

@section('content')

    @include('sections.nav')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="video-box ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/a1hEY3Ii70I" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        </div>
                        <div class="video-info">
                            <div class="video-caption">
                                <div class="video-title"><h3>Incentive</h3></div>
                                <div class="published">
                                    Published <span>15-12-2022</span>
                                </div>
                            </div>
                            <div class="video-statistics">
                                <div class="video-views"><i class="fa-solid fa-eye"></i> <span class="views-number">203K</span></div>
                                <div class="video-comments"><i class="fa-solid fa-comment-dots"></i> <span class="views-number">203K</span></div>
                            </div>
                        </div>
                        <hr>
                        <div class="comments-section">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('sections.footer')
    </div>
    @include('sections.scripts')
@endsection
