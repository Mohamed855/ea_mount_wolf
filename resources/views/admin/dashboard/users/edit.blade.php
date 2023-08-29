@extends('layouts.app')

@section('title', 'Edit ' . $selected_user->user_name)

@section('content')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="brain-box-title pb-3">
                            <h3 class="d-inline">{{ 'Edit ' . $selected_user->user_name }}</h3>
                        </div>
                        <div class="col-lg-7 m-auto">
                            <form action="{{ route('users.update', $selected_user->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="col-lg-5 d-inline-block">
                                    <div class="pb-2 px-1">
                                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ $selected_user->first_name }}" placeholder="First Name *">
                                        @error('first_name')
                                            <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <input type="text" name="middle_name" class="form-control @error('middle_name') is-invalid @enderror" value="{{ $selected_user->middle_name }}" placeholder="Middle Name *">
                                        @error('middle_name')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ $selected_user->last_name }}" placeholder="Last Name *">
                                        @error('last_name')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <input type="text" name="user_name" class="form-control @error('user_name') is-invalid @enderror" value="{{ $selected_user->user_name }}" placeholder="User Name *">
                                        @error('user_name')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $selected_user->email }}" placeholder="@averroes-eg.com *">
                                        @error('email')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-5 d-inline-block pt-0">
                                    <div class="pb-2 px-1">
                                        <input type="text" name="crm_code" class="form-control @error('crm_code') is-invalid @enderror" value="{{ $selected_user->crm_code }}" placeholder="CRM Code *">
                                        @error('crm_code')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ $selected_user->phone_number }}" placeholder="Phone Number *">
                                        @error('phone_number')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <select name="sector" class="form-control @error('sector') is-invalid @enderror">
                                            <option value="0">Sector *</option>
                                            @foreach($sectors as $sector)
                                                <option value="{{ $sector->id }}" {{ $sector->id == $selected_user->sector_id ? 'selected' : '' }}>{{ $sector->name }}</option>
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
                                                <option value="{{ $title->id }}" {{ $title->id == $selected_user->title_id ? 'selected' : '' }}>{{ $title->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('title')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <select name="line" class="form-control @error('line') is-invalid @enderror">
                                            <option value="0">Line *</option>
                                            @foreach($lines as $line)
                                                <option value="{{ $line->id }}" {{ $line->id == $selected_user->line_id ? 'selected' : '' }}>{{ $line->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('line')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    @if(session()->has('savedSuccessfully'))
                                        <div class="m-auto">
                                            <span class="text-primary" role="alert">{{ session()->get('savedSuccessfully') }}</span>
                                        </div>
                                    @endif
                                    <button type="submit" class="btn btn-outline-primary p-2 my-2 mx-lg-2">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
