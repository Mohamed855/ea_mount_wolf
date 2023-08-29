@extends('layouts.app')

@section('title', 'Edit ' . $selected_topic->title)

@section('content')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="brain-box-title pb-3">
                            <h3 class="d-inline">{{ 'Edit ' . $selected_topic->title }}</h3>
                        </div>
                        <div class="col-lg-7 m-auto">
                            <form action="{{ route('ea_topics.update', $selected_topic->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="col-lg-6 m-auto py-2">
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $selected_topic->title }}" placeholder="Topic title">
                                    @error('title')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 m-auto py-2">
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="Topic description" style="min-height: 200px">{{ $selected_topic->description }}</textarea>
                                    @error('description')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 m-auto py-2">
                                    <input type="file" name="image" id="file" class="btn btn-outline-primary @error('image') is-invalid @enderror" accept="image/png, image/gif, image/jpeg">
                                    <br>
                                    @error('image')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if(session()->has('savedSuccessfully'))
                                    <div class="m-auto">
                                        <span class="text-primary" role="alert">{{ session()->get('savedSuccessfully') }}</span>
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-outline-primary p-2 my-2 mx-lg-2">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
