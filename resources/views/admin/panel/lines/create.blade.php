@extends('layouts.panel')

@section('title', 'Add Line')

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
                            <h3 class="pb-4">Add New Line</h3>
                            <form action="{{ route('lines.store') }}" method="POST">
                                @csrf
                                <div class="col-md-10 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="name" class="form-control py-2" value="{{ old('name') }}" placeholder="Line Name">
                                    </div>
                                </div>
                                <div class="col-12 col-md-10 p-3 mb-3 m-auto border rounded">
                                    <div class="row">
                                        <h6 class="text-start">Choose sectors</h6>
                                        @foreach($sectors as $sector)
                                            <div class="col-12 col-md-6 col-xxl-4 text-start">
                                                <input type="checkbox" id="{{ 's_' . $sector->id }}" name="{{ 's_' . $sector->id }}" value="{{ $sector->id }}" {{ $sector->id == old('s_' . $sector->id) ? 'checked' : '' }} style="cursor:pointer">
                                                <label class="small" for="{{ 's_' . $sector->id }}">{{ $sector->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-10 col-12 m-auto">
                                    <button type="submit" class="btn submit_btn p-2 my-3 w-100">Create Line</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
