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

                            <div class="col-sm-4 col-lg-3">
                                <input type="date" class="form-control">
                            </div>
                        </div>
                        <hr>
                        <div class="content mCustomScrollbar">
                            <div class="incentives-section">
                                @if(count($favorites) > 0)
                                    @foreach($favorites as $file)
                                        <div class="incentive-box favorite">
                                            <span>
                                                <a href="{{ route('favorites.toggle', $file->file_id) }}">
                                                    <img src="{{ asset('images/icons/star.png') }}" style="max-width: 16px">
                                                </a>
                                            </span>
                                            <a href="{{ route('file.download', $file->id) }}">
                                                <div class="incentive-title">{{ $file->name }}</div>
                                                <div class="incentive-body">
                                                    <div class="incentive-txt">Published<br>{{ $file->created_at }}</div>
                                                    <div class="incentive-info-box">
                                                        <div class="incentive-info in-views">
                                                            <img src="{{ asset('images/icons/eye_light.svg') }}" style="max-width: 16px" alt="">
                                                            {{ $file->viewed }}
                                                        </div>
                                                        @php($file_icon = "")
                                                        @if (str_contains($file->type, 'word'))
                                                            @php($file_icon = "word-icon.svg")
                                                        @elseif (str_contains($file->type, 'excel'))
                                                            @php($file_icon = "excel-icon.svg")
                                                        @elseif (str_contains($file->type, 'pdf'))
                                                            @php($file_icon = "pdf-icon.svg")
                                                        @elseif (str_contains($file->type, 'video'))
                                                            @php($file_icon = "video-icon.svg")
                                                        @elseif (str_contains($file->type, 'zip'))
                                                            @php($file_icon = "zip-icon.svg")
                                                        @elseif (str_contains($file->type, 'jpg') || str_contains($file->type, 'jpeg'))
                                                            @php($file_icon = "jpg-icon.svg")
                                                        @elseif (str_contains($file->type, 'png'))
                                                            @php($file_icon = "png-icon.svg")
                                                        @elseif (str_contains($file->type, 'gif'))
                                                            @php($file_icon = "gif-icon.svg")
                                                        @else
                                                            @php($file_icon = "default-icon.svg")
                                                        @endif
                                                        <div class="incentive-info in-files">
                                                            <img src="{{ asset('images/icons/extensions/'.$file_icon) }}" style="max-width: 16px" alt="">
                                                        </div>
                                                        <div class="incentive-info in-comments">
                                                            <img src="{{ asset('images/icons/pen-icon.svg') }}" style="max-width: 16px" alt="">
                                                            {{ floor($file->size / 1000) < 1000 ?  floor($file->size / 1000) . ' K' :  floor($file->size / 1000 / 1000) . ' Mb' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="m-auto">
                                        <p class="fs-4 p-5">Add some files to favorites</p>
                                    </div>
                                @endif

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
