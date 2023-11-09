@extends('layouts.panel')

@section('title', 'Add Admin')

@section('panel_content')
    <div class="container px-4">
        @if(session()->has('uploadedSuccessfully'))
            <div class="alert alert-success text-center m-auto mb-2 col-12 col-lg-8" role="alert">
                {{ session('uploadedSuccessfully') }}
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
                            <h3 class="pb-4">Add New Admin</h3>
                            <div class="m-auto">
                                <form action="{{ route('admins.store') }}" method="POST">
                                    @csrf
                                    <div class="col-md-10 col-12 m-auto row">
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="first_name" class="form-control py-2" value="{{ old('first_name') }}" placeholder="First Name">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="middle_name" class="form-control py-2" value="{{ old('middle_name') }}" placeholder="Middle Name">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="last_name" class="form-control py-2" value="{{ old('last_name') }}" placeholder="Last Name">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="email" class="form-control py-2" value="{{ old('email') }}" placeholder="Email">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="password" class="form-control py-2" value="{{ old('password') }}" placeholder="Password">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="crm_code" class="form-control py-2" value="{{ old('crm_code') }}" placeholder="CRM Code">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="phone_number" class="form-control py-2" value="{{ old('phone_number') }}" placeholder="Phone Number">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <select name="sector" class="form-control @error('sector') is-invalid @enderror">
                                                <option value="0">Sector *</option>
                                                @foreach($sectors as $sector)
                                                    <option value="{{ $sector->id }}" {{ $sector->id == old('sector') ? 'selected' : '' }}>{{ $sector->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <select name="title" class="form-control @error('title') is-invalid @enderror">
                                                <option value="0">Title *</option>
                                                @foreach($titles as $title)
                                                    <option value="{{ $title->id }}" {{ $title->id == old('title') ? 'selected' : '' }}>{{ $title->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <select name="line" class="form-control @error('line') is-invalid @enderror">
                                                <option value="0">Line *</option>
                                                @foreach($lines as $line)
                                                    <option value="{{ $line->id }}" {{ $line->id == old('line') ? 'selected' : '' }}>{{ $line->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-12 m-auto">
                                        <button type="submit" class="btn submit_btn p-2 my-3 w-100">Add Admin</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
