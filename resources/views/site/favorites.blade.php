@extends('layouts.app')

@section('title', 'Employee Access - favorites')

@section('content')

    @include('sections.nav')
    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <h3 class="text-center">Favorites</h3>
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
                                @for($i = 1; $i <= 18; $i++)
                                    @include('sections.widgets.incentive-box')
                                @endfor
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

    <script src="{{ asset('assets/js/custom-select.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
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
