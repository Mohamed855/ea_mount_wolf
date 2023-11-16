@extends('layouts.app')

@section('title', 'Employee Access')

@section('content')

    @include('includes.front.navbar')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="announcement-title {{ count($announcements) > 0 ? 'image-bar' : '' }}">
                            @if(count($announcements) > 0)
                                @foreach ($announcements as $announcement)
                                    <div
                                        style="background-image: url('{{ asset('storage/images/announcements/' . $announcement->image) }}')" {{ $loop->first ? 'class=active' : '' }}></div>
                                @endforeach
                            @else
                                <div class="announcement-logo"><img src="{{ asset('storage/images/logos/logo.png') }}"
                                                                    class="mw-100" alt=""></div>
                                <div class="announcement-title-txt">AVS Announcements</div>
                            @endif
                        </div>
                        @if(session()->has('notAuthorized'))
                            <div class="alert alert-danger text-center m-auto mb-2 justify-content-evenly col-10 col-md-8">
                                {{ session('notAuthorized') }}
                            </div>
                        @endif
                        <div class="departments-section justify-content-evenly m-auto col-10">
                            @php($userSectors = [])
                            @if(auth()->user()->role != 1)
                                @php($userSectors = array_map('intval', auth()->user()->sectors))
                            @endif
                            @php(auth()->user()->role != 1 ? $isNotAdmin = true : $isNotAdmin = false)
                            @foreach($sectors as $sector)
                                <div class="department-box col-12 col-md-5 col-lg-4 col-xl-3 {{ in_array($sector->id, $userSectors) && $isNotAdmin ? 'active' : '' }} ">
                                    <a href="
                                    @if (auth()->user()->role == 1 || in_array(1, $userSectors) || in_array($sector->id, $userSectors) )
                                        {{ route('sector_line.choose', $sector->id) }}
                                    @else
                                        {{ route('not_authorized') }}
                                    @endif
                                    "
                                       class="text-decoration-none sector_text {{ in_array($sector->id, $userSectors) && $isNotAdmin ?  'sector_active' : ''}}">
                                        <div class="department-title">{{ $sector->name }}</div>
                                        <div class="department-views">
                                            Views <img
                                                src="{{ asset(in_array($sector->id, $userSectors) && $isNotAdmin ?  'storage/images/icons/eye_light.svg' : 'storage/images/icons/eye.svg') }}"
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
