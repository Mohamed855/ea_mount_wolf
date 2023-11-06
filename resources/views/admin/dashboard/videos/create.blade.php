@extends('layouts.app')

@section('title', 'Add Video')

@section('content')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="brain-box-title pb-3">
                            <h3 class="d-inline">Add New Video</h3>
                        </div>
                        <div class="col-lg-7 m-auto">
                            <form action="{{ route('videos.store') }}" method="POST">
                                @csrf
                                <div class="col-lg-6 m-auto py-2">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Video Name">
                                    @error('name')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 m-auto py-2">
                                    <input type="text" name="src" class="form-control @error('src') is-invalid @enderror" value="{{ old('src') }}" placeholder="Youtube Link">
                                    @error('src')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 m-auto py-2">
                                    <select name="sector" class="form-control @error('sector') is-invalid @enderror">
                                        <option value="0">Sector *</option>
                                        @if(auth()->user()->sector_id == 1)
                                            @foreach($sectors as $sector)
                                                <option value="{{ $sector->id }}" {{ $sector->id == old('sector') ? 'selected' : '' }}>{{ $sector->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="{{ $user_sector->id }}">{{ $user_sector->name }}</option>
                                        @endif
                                    </select>
                                    @error('sector')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 m-auto py-2">
                                    <select name="line" class="form-control @error('line') is-invalid @enderror">
                                        <option value="0">Line *</option>
                                        @foreach($lines as $line)
                                            <option value="{{ $line->id }}" {{ $line->id == old('line') ? 'selected' : '' }}>{{ $line->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('line')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if(session()->has('uploadedSuccessfully'))
                                    <div class="m-auto">
                                        <span class="text-primary" role="alert">{{ session()->get('uploadedSuccessfully') }}</span>
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-outline-primary p-2 my-2 mx-lg-2">Add video</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection