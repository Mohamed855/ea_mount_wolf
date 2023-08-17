@extends('layouts.app')

@section('title', 'Employee Access')

@section('content')

    @include('sections.nav')

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
                        <div class="announcement-title">
                            <div class="announcement-logo"><img src="{{ asset('images/logos/logo.png') }}" class="mw-100" alt=""></div>
                            <div class="announcement-title-txt">AVS Announcement</div>
                        </div>
                        <div class="date py-5">
                            <form>
                                <div class="row form-group justify-content-around">
                                    @if(auth()->user()->sector_id == 1)
                                        <div class="col-sm-4 col-lg-3">
                                            <a href="{{ route('dashboard') }}" class="btn mb-2 mb-lg-0 w-100 control-btn">Dashboard</a>
                                        </div>
                                    @endif

                                    @if(auth()->user()->role == 1)
                                        <div class="col-sm-4 col-lg-3">
                                            <a href="{{ route('ea_files.create') }}" class="btn mb-2 mb-lg-0 w-100 control-btn">Add Files</a>
                                        </div>
                                    @endif

                                    <div class="col-sm-4 col-lg-3">
                                        <input type="date" class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="departments-section">
                            @foreach($sectors as $sector)
                                    <div class="department-box {{ $sector->id == auth()->user()->sector_id ?  'active' : ''}}">
                                        <a href="{{ auth()->user()->sector_id !== $sector->id && auth()->user()->sector_id !== 1 ?
                                                route('not_authorized') :
                                                route('drive', ['sector_id' => $sector->id, 'line_id' => auth()->user()->line_id]) }} "
                                           class="text-decoration-none sector_text {{ $sector->id == auth()->user()->sector_id ?  'sector_active' : ''}}">
                                            <div class="department-title">{{ $sector->name }}</div>
                                            <div class="department-views">
                                                Views <img src="{{ asset($sector->id == auth()->user()->sector_id ?  'images/icons/eye_light.svg' : 'images/icons/eye.svg') }}" style="max-width: 20px;" />
                                                <span class="views-number">{{ $sector->views_number }}</span>
                                            </div>
                                        </a>
                                    </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('sections.footer')

    </div>

    @include('sections.scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $('#datepicker').datepicker();
        });
    </script>
@endsection
