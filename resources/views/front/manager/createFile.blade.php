@extends('layouts.app')

@section('title', 'Add File')

@section('content')

    @include('includes.front.navbar')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="container px-4">
                        @if(session()->has('uploadedSuccessfully'))
                            <div class="alert alert-success text-center m-auto mb-2 col-12 col-lg-8" role="alert">
                                {{ session('uploadedSuccessfully') }}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger text-center m-auto mb-2 col-12 col-lg-8" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="col-12 col-lg-8 m-auto">
                        <div class="overflow-scroll border bg-white shadow rounded-2 py-5 px-4 px-lg-5">
                            <h3 class="pb-4">Add New File</h3>
                            <form action="{{ route('ea_files.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-8 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="name" class="form-control py-2" value="{{ old('name') }}" placeholder="File Name">
                                    </div>
                                    <div class="pb-3">
                                        <select name="sector" class="form-control @error('sector') is-invalid @enderror">
                                            <option value="0">Sector *</option>
                                            @if(auth()->user()->sector_id == 1)
                                                @foreach($sectors as $sector)
                                                    <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="{{ $user_sector->id }} {{ $user_sector->id == old('sector') ? 'selected' : '' }}">{{ $user_sector->name }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="pb-3">
                                        <select name="line" class="form-control @error('line') is-invalid @enderror">
                                            <option value="0">Line *</option>
                                            @foreach($lines as $line)
                                                <option value="{{ $line->id }} {{ $line->id == old('line') ? 'selected' : '' }}">{{ $line->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8 col-12 m-auto">
                                    <div class="pb-3">
                                        <input type="file" name="file" id="file" class="form-control py-2" accept="*/*">
                                    </div>
                                </div>
                                <div class="col-md-8 col-12 m-auto">
                                    <button type="submit" class="btn submit_btn p-2 my-3 w-100">Add file</button>
                                    <span class="text-dark">Max size is 10 MB</span>
                                </div>
                            </form>
                        </div>
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
