@extends('layouts.app')

@section('title', 'Add User')

@section('content')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="brain-box-title pb-3">
                            <h3 class="d-inline">Add New User</h3>
                        </div>
                        <div class="col-lg-7 m-auto">
                            <form action="{{ route('users.store') }}" method="POST">
                                @csrf
                                <div class="col-lg-5 d-inline-block">
                                    <div class="pb-2 px-1">
                                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" placeholder="First Name *">
                                        @error('first_name')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <input type="text" name="middle_name" class="form-control @error('middle_name') is-invalid @enderror" value="{{ old('middle_name') }}" placeholder="Middle Name *">
                                        @error('middle_name')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="Last Name *">
                                        @error('last_name')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="@averroes-eg.com *">
                                        @error('email')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <input type="text" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password *">
                                        @error('password')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-5 d-inline-block pt-0">
                                    <div class="pb-2 px-1">
                                        <input type="text" name="crm_code" class="form-control @error('crm_code') is-invalid @enderror" value="{{ old('crm_code') }}" placeholder="CRM Code *">
                                        @error('crm_code')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" placeholder="Phone Number *">
                                        @error('phone_number')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <select name="sector" class="form-control @error('sector') is-invalid @enderror">
                                            <option value="0">Sector *</option>
                                            @foreach($sectors as $sector)
                                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('sector')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <select name="title" class="form-control @error('title') is-invalid @enderror">
                                            <option value="0">Title *</option>
                                            @foreach($titles as $title)
                                                <option value="{{ $title->id }}">{{ $title->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('title')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <select name="line" class="form-control @error('line') is-invalid @enderror">
                                            <option value="0">Select Line *</option>
                                            @foreach($lines as $line)
                                                <option value="{{ $line->id }}">{{ $line->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('line')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    @if(session()->has('uploadedSuccessfully'))
                                        <div class="m-auto">
                                            <span class="text-primary" role="alert">{{ session()->get('uploadedSuccessfully') }}</span>
                                        </div>
                                    @endif
                                    <button type="submit" class="btn btn-outline-primary p-2 my-2 mx-lg-2">Add User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
