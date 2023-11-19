@extends('layouts.panel')

@section('title', 'Add Video')

@section('panel_content')
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
    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row text-center">
                    <div class="col-12 col-lg-8 m-auto">
                        <div class="overflow-scroll border bg-white shadow rounded-2 py-5 px-4 px-lg-5">
                            <h3 class="pb-4">Add New Video</h3>
                            <form action="{{ route('videos.store') }}" method="POST">
                                @csrf
                                <div class="col-md-10 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="name" class="form-control py-2" value="{{ old('name') }}" placeholder="Video Name">
                                    </div>
                                    <div class="pb-3">
                                        <input type="text" name="src" class="form-control py-2" value="{{ old('src') }}" placeholder="Video Link">
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
                                            <div id="{{ 'sl_' . $sl->id }}" style="display: {{ $sl->id == old('s_' . $sl->id) ? 'flex' : 'none' }}">
                                                @php($lines = \App\Models\Line::query()
                                                        ->join('line_sector as ls', 'ls.line_id', '=', 'lines.id')
                                                        ->where('ls.sector_id', $sl->id)
                                                        ->where('lines.status', 1)
                                                        ->select(['lines.id', 'lines.name'])
                                                        ->orderBy('lines.id')->get()
                                                    )
                                                <div class="col-12 p-3 mt-2 mb-3 border rounded">
                                                    <div class="row">
                                                        <h6 class="text-start">{{ $sl->name }}</h6>
                                                        @foreach($lines as $line)
                                                            <div class="col-12 col-md-6 col-xxl-4 text-start">
                                                                <input type="radio" name="{{ 'line' }}" value="{{ $line->id }}" {{ $line->id == old('line') ? 'checked' : '' }} style="cursor:pointer">
                                                                <label class="small" for="{{ 'line' . $line->id }}">{{ $line->name }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-10 col-12 m-auto">
                                    <button type="submit" class="btn submit_btn p-2 my-3 w-100">Add video</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.admin.scripts')
@endsection
