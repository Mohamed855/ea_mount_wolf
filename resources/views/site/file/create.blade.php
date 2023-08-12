@extends('layouts.app')

@section('title', 'Add File')

@section('content')

    @include('sections.nav')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="brain-box-title">
                            <h3 class="d-inline">Add New File</h3>
                        </div>
                        <div class="col-lg-7 m-auto">
                            <form action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-lg-6 m-auto py-2">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="File Name">
                                    @error('name')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 m-auto py-2">
                                    <select name="line" class="form-control @error('line') is-invalid @enderror">
                                        <option value="0">Select Line *</option>
                                        <option value="1">Line 1</option>
                                        <option value="2">Line 2</option>
                                        <option value="3">Line 3</option>
                                        <option value="4">Line 4</option>
                                        <option value="5">Line 5</option>
                                    </select>
                                    @error('line')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6 m-auto py-2">
                                    <input type="file" name="file" id="file" class="btn btn-outline-primary @error('file') is-invalid @enderror" accept="*/*" required>
                                    @error('file')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if(session()->has('uploadedSuccessfully'))
                                    <div class="m-auto">
                                        <span class="text-primary" role="alert">{{ session()->get('uploadedSuccessfully') }}</span>
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-outline-primary p-2 my-2 mx-lg-2">Add file</button>
                                <span class="text-dark">Max size is 2048 MB</span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
