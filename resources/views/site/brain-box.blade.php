@extends('layouts.app')

@section('title', 'Employee Access - Brain Box')

@section('content')

    @include('sections.nav')

    <div class="content-wraper withnav">
      <div class="body-content">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-12">
              <div class="brain-box-title">
                <h2 class="text-center">Brain Box</h2>
                <h5 class="text-center">Pedia line - Brain Box</h5>
              </div>
              <div class="brain-box ratio ratio-16x9">

              </div>

              <div class="comments-section brain-box-comments">
                  @for($i = 0; $i <= 3; $i++)
                      @include('sections.widgets.comment-box')
                  @endfor
                <div class="comment-box write-comment">
                  <div class="comment-info">
                    <div class="prof-pic bg-styles" style="background-image:url({{ asset('images/comment-1.jpg') }});"></div>
                    <div class="comment-name">Employee Name</div>
                    <div class="comment-title">Title</div>
                  </div>
                  <div class="comment-txt">
                    <div class="input-group mb-3">
                      <textarea type="text" class="form-control" placeholder="Write a comment.." aria-label="Write a comment.." aria-describedby="button-addon2"></textarea>
                      <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fa-regular fa-paper-plane"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="related-topics">
                <h3 class="text-start">Related Topics:</h3>
                <div id="topics-carousel" class="owl-carousel owl-theme wow fadeInDown">
                  <div class="topic-box"></div>
                  <div class="topic-box"></div>
                  <div class="topic-box"></div>
                  <div class="topic-box"></div>
                  <div class="topic-box"></div>
                  <div class="topic-box"></div>
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
