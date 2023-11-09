@extends('layouts.app')

@section('title', 'Employee Access')

@section('content')

    @include('includes.front.navbar')

    @if(session()->has('notAuthorized'))
        <script>
            alert('You are not authorized')
        </script>
    @endif

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="announcement-title {{ count($announcements) > 0 ? 'image-bar' : '' }}">
                            @if(count($announcements) > 0)
                                @foreach ($announcements as $announcement)
                                    <div
                                        style="background-image: url('{{ asset('../public/images/announcements/' . $announcement->image) }}')" {{ $loop->first ? 'class=active' : '' }}></div>
                                @endforeach
                            @else
                                <div class="announcement-logo"><img src="{{ asset('../public/images/logos/logo.png') }}"
                                                                    class="mw-100" alt=""></div>
                                <div class="announcement-title-txt">AVS Announcements</div>
                            @endif
                        </div>
                        <div class="date pb-5">
                            <form>
                                <div class="row form-group justify-content-evenly col-10 m-auto">
                                    @if(auth()->user()->role == 1)
                                        <div class="col-12 col-lg-7">
                                            <a href="{{ route('panel') }}" class="btn py-2 mb-2 mb-lg-0 w-100 control-btn">Dashboard</a>
                                        </div>
                                    @elseif(auth()->user()->role == 2)
                                        <div class="col-12 col-lg-5 py-2">
                                            <a href="{{ route('file.add') }}"
                                               class="btn py-2 mb-2 mb-lg-0 w-100 control-btn">Add Files</a>
                                        </div>
                                        <div class="col-12 col-lg-5 py-2">
                                            <a href="{{ route('video.add') }}"
                                               class="btn py-2 mb-2 mb-lg-0 w-100 control-btn">Add Video</a>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="departments-section justify-content-evenly m-auto col-10">
                            @php($current_user_sector_id = auth()->user()->sector_id)
                            @php(auth()->user()->role != 1 ? $isNotAdmin = true : $isNotAdmin = false)
                            @foreach($sectors as $sector)
                                <div class="department-box col-12 col-md-5 col-lg-4 col-xl-3 {{ $sector->id == $current_user_sector_id && $isNotAdmin ? 'active' : '' }} ">
                                    <a href="
                                    @if ($current_user_sector_id !== $sector->id && auth()->user()->role !== 1)
                                        {{ route('not_authorized') }}
                                    @elseif ($current_user_sector_id === $sector->id && $current_user_sector_id !== 1 && auth()->user()->role !== 1)
                                        {{ route('drive', ['sector_id' => $sector->id, 'line_id' => auth()->user()->line_id]) }}
                                    @else
                                        {{ route('sector_line.choose', $sector->id) }}
                                    @endif
                                    "
                                       class="text-decoration-none sector_text {{ $sector->id == $current_user_sector_id && $isNotAdmin ?  'sector_active' : ''}}">
                                        <div class="department-title">{{ $sector->name }}</div>
                                        <div class="department-views">
                                            Views <img
                                                src="{{ asset($sector->id == $current_user_sector_id && $isNotAdmin ?  '../public/images/icons/eye_light.svg' : '../public/images/icons/eye.svg') }}"
                                                style="max-width: 20px;"/>
                                            <span
                                                class="views-number">{{ $views->where('sector_id', '=', $sector->id)->count() + $downloads->where('sector_id', '=', $sector->id)->count() }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.front.footer')
    </div>

    @include('includes.front.scripts')
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        var images = document.querySelectorAll(".image-bar div");
        var index = 0;

        setInterval(function () {
            images[index].classList.remove("active");
            index = (index + 1) % images.length;
            images[index].classList.add("active");
        }, 30000);
    </script>

    <script type="text/javascript">
        $(function () {
            $('#datepicker').datepicker();
        });
    </script>
@endsection
