@extends('layouts.app')

@section('title', 'Add Sector')

@section('content')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="brain-box-title pb-3">
                            <h3 class="d-inline">Add New Sector</h3>
                        </div>
                        <div class="col-lg-7 m-auto">
                            <form action="{{ route('sectors.store') }}" method="POST">
                                @csrf
                                <div class="col-lg-6 m-auto py-2">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Sector Name">
                                    @error('name')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label for="lines[]">Lines *</label>
                                <div class="col-lg-6 m-auto py-2">
                                    <select name="lines[]" class="form-control @error('lines[]') is-invalid @enderror" multiple="multiple">
                                        @foreach($lines as $line)
                                            <option value="{{ $line->id }}">{{ $line->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('lines[]')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            @if(session()->has('uploadedSuccessfully'))
                                <div class="m-auto">
                                    <span class="text-primary" role="alert">{{ session()->get('uploadedSuccessfully') }}</span>
                                </div>
                            @endif
                            <button type="submit" class="btn btn-outline-primary p-2 my-2 mx-lg-2">Create Sector</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
