@extends('layouts.app')

@section('title', 'Employee Access - Brain Box')

@section('content')

    @include('sections.nav')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="controle row">
                            <div class="col-md-3">
                                <div class="group-by">
                                    <div class="custom-selects">
                                        <select name="title">
                                            <option value="0">Group by</option>
                                            <option value="1">Date</option>
                                            <option value="2">Name</option>
                                            <option value="3">Department</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="date">
                                    <div class="form-group">
                                        <div class="input-group date" id="datepicker">
                                            <input type="text" class="form-control">
                                            <span class="input-group-append">
                      <span class="input-group-text d-block"><i class="fa fa-calendar"></i></span>
                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="content mCustomScrollbar">
                            <div class="incentives-section">
                                <div class="incentives-section">
                                    @foreach($files as $file)
                                        <a href="{{ route('file.show', $file->id) }}">
                                            <div class="incentive-box favorite">
                                                <span><i class="fa-solid fa-star"></i></span>
                                                <div class="incentive-title">{{ $file->name }}</div>
                                                <div class="incentive-body">
                                                    <div class="incentive-txt">Published<br>{{ $file->created_at }}</div>
                                                    <div class="incentive-info-box">
                                                        <div class="incentive-info in-views"><i class="fa-solid fa-eye"></i> 203K</div>
                                                        <div class="incentive-info in-files">
                                                            <img src="{{ asset('images/pdf-icon.svg') }}" class="mw-100" alt="">
                                                        </div>
                                                        <div class="incentive-info in-comments"><i class="fa-solid fa-comment-dots"></i> 203K</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('sections.footer')
    </div>

    @include('sections.scripts')
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
