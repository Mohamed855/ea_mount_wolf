@extends('layouts.panel')

@section('title', 'Edit ' . $selected_line->name)

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
                            <h3 class="pb-4">{{ 'Edit ' . $selected_line->name }}</h3>
                            <form action="{{ route('lines.update', $selected_line->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="col-md-8 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="name" class="form-control py-2" value="{{ $selected_line->name }}" placeholder="Line Name">
                                    </div>
                                    <div class="pb-3">
                                        <select name="sectors[]" class="form-control py-2" multiple="multiple">
                                            @foreach($sectors as $sector)
                                                <option value="{{ $sector->id }}"
                                                @foreach($selected_sectors as $selected_sector)
                                                    {{ $selected_sector->sector_id == $sector->id ? 'selected' : '' }}
                                                    @endforeach
                                                >{{ $sector->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8 col-12 m-auto">
                                    <button type="submit" class="btn submit_btn p-2 my-3 w-100">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
