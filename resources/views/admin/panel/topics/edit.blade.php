@extends('layouts.panel')

@section('title', 'Edit ' . $selected_topic->title)

@section('panel_content')
    <div class="container px-4">
        @if(session()->has('savedSuccessfully'))
            <div class="alert alert-success text-center m-auto mb-2 col-12 col-lg-8" role="alert">
                {{ session('savedSuccessfully') }}
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
                            <h3 class="pb-4">{{ 'Edit ' . $selected_topic->title }}</h3>
                            <form action="{{ route('ea_topics.update', $selected_topic->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="col-md-8 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="title" class="form-control py-2" value="{{ $selected_topic->title }}" placeholder="Topic title">
                                    </div>
                                    <div class="pb-3">
                                        <textarea name="description" class="form-control py-2" placeholder="Topic description" style="min-height: 200px">{{ $selected_topic->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-8 col-12 m-auto">
                                    <div class="pb-3">
                                        <input type="file" name="image" id="file" class="form-control py-2" accept="image/png, image/gif, image/jpeg">
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
