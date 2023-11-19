@extends('layouts.app')

@section('title', 'Add File')

@section('content')

    @include('includes.front.navbar')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="container px-4">
                        @if(session()->has('success'))
                            <div class="alert alert-success text-center m-auto mb-2 col-12 col-lg-8" role="alert">
                                {{ session('success') }}
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
                                    <div class="col-12 p-3 mt-2 mb-3 border rounded">
                                        <div class="row">
                                            <h6 class="text-start">Choose sector</h6>
                                            @foreach($sectors as $sector)
                                                <div class="col-12 col-md-6 col-xxl-4 text-start">
                                                    <input type="radio" id="{{ 's_' . $sector->id }}" name="{{ 'sector' }}" value="{{ $sector->id }}" {{ $sector->id == old('sector') ? 'checked' : '' }} style="cursor:pointer" onchange="generateOneSectorLines({{ $sector->id }})">
                                                    <label class="small" for="{{ 'sector' }}">{{ $sector->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-12 p-3 mb-3 border rounded">
                                        <h6 class="text-start">Choose line</h6>
                                        @foreach($sectors as $sl)
                                            @php($integerSectorIds = array_map('intval', auth()->user()->sectors))
                                            <div id="{{ 'sl_' . $sl->id }}" style="display: {{ $sl->id == old('s_' . $sl->id) ? 'flex' : 'none' }}">
                                                @php($manager_lines = \App\Models\ManagerLines::query()
                                                    ->where('user_id', auth()->id())
                                                    ->whereIn('sector_id', $integerSectorIds)
                                                    ->get())

                                                <div class="col-12 p-3 mt-2 mb-3 border rounded">
                                                    <div class="row">
                                                        <h6 class="text-start">{{ $sl->name }}</h6>
                                                        @php($lines = \App\Models\Line::query()->get())
                                                        @for($i = 0; $i < count($manager_lines); $i++)
                                                            @foreach($lines as $line)
                                                                @if($manager_lines[$i]->sector_id == $sl->id && in_array($line->id, $manager_lines[$i]->lines))
                                                                    <div class="col-12 col-md-6 col-xxl-4 text-start">
                                                                        <input type="radio" name="{{ 'line' }}" value="{{ $line->id }}" {{ $line->id == old('line') ? 'checked' : '' }} style="cursor:pointer">
                                                                        <label class="small" for="{{ 'line' }}">{{ $line->name }}</label>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
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
    @include('includes.admin.scripts')

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
