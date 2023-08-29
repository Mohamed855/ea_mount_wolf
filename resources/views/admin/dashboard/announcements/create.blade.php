@extends('layouts.app')

@section('title', 'Add Topic')

@section('content')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="brain-box-title pb-3">
                            <h3 class="d-inline">Add New Announcement</h3>
                        </div>
                        <div class="col-lg-7 m-auto">
                            <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-lg-6 m-auto py-2">
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Announcement title">
                                    @error('title')
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
                                @if(session()->has('uploadedSuccessfully'))
                                    <div class="m-auto">
                                        <span class="text-primary" role="alert">{{ session()->get('uploadedSuccessfully') }}</span>
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-outline-primary p-2 my-2 mx-lg-2">Add Announcement</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
