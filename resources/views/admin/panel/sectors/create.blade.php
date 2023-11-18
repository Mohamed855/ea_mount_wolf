@extends('layouts.panel')

@section('title', 'Add Sector')

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
                            <h3 class="pb-4">Add New Sector</h3>
                            <form action="{{ route('sectors.store') }}" method="POST">
                                @csrf
                                <div class="col-md-10 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="name" class="form-control py-2" value="{{ old('name') }}" placeholder="Sector Name">
                                    </div>
                                </div>
                                <div class="col-12 col-md-10 p-3 mb-3 m-auto border rounded">
                                    <div class="row">
                                        <h6 class="text-start">Choose lines</h6>
                                        @foreach($lines as $line)
                                            <div class="col-12 col-md-6 col-xxl-4 text-start">
                                                <input type="checkbox" id="{{ 'l_' . $line->id }}" name="{{ 'l_' . $line->id }}" value="{{ $line->id }}" {{ $line->id == old('l_' . $line->id) ? 'checked' : '' }} style="cursor:pointer">
                                                <label class="small" for="{{ 'l_' . $line->id }}">{{ $line->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-10 col-12 m-auto">
                                    <button type="submit" class="btn submit_btn p-2 my-3 w-100">Create Sector</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
