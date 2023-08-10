@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="content-wraper">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-9">
                        <div class="main-logo"><img src="{{ asset('images/logo.png') }}" class="mw-100" alt=""></div>
                        <div class="ea-form signup-form">
                            <form action="{{ route('user.store') }}" method="POST">
                                @csrf
                                <div>
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" placeholder="First Name *">
                                    @error('first_name')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <input type="text" name="middle_name" class="form-control @error('middle_name') is-invalid @enderror" value="{{ old('middle_name') }}" placeholder="Middle Name *">
                                    @error('middle_name')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="Last Name *">
                                    @error('last_name')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <input type="text" name="crm_code" class="form-control @error('crm_code') is-invalid @enderror" value="{{ old('crm_code') }}" placeholder="CRM Code *">
                                    @error('crm_code')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="custom-selects">
                                        <select name="title" class="form-control @error('title') is-invalid @enderror">
                                            <option value="0">Title *</option>
                                            <option value="MR">MR</option>
                                            <option value="DM">DM</option>
                                            <option value="AM">AM</option>
                                            <option value="LM">LM</option>
                                            <option value="BUM">BUM</option>
                                            <option value="OB">Office Based</option>
                                        </select>
                                    </div>
                                    @error('title')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <div class="custom-selects">
                                        <select name="line" class="form-control @error('line') is-invalid @enderror">
                                            <option value="0">Select Line *</option>
                                            <option value="1">Line 1</option>
                                            <option value="2">Line 2</option>
                                            <option value="3">Line 3</option>
                                            <option value="4">Line 4</option>
                                            <option value="5">Line 5</option>
                                        </select>
                                    </div>
                                    @error('line')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="@averroes-eg.com *">
                                    @error('email')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" placeholder="Phone Number *">
                                    @error('phone_number')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password *">
                                    @error('password')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <input type="password" name="password_confirmation" class="form-control @error('password') is-invalid @enderror" placeholder="Confirm Password *">
                                    @error('password_confirmation')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="signup-btns-con">
                                    <button type="submit" class="ea-btns dark-btn">Sign Up</button>
                                    <a href="{{ route('login') }}">Log In</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('sections.logoFooter')
    </div>

    @include('sections.scripts')
    <script src="{{ asset('assets/js/custom-select.js') }}"></script>
@endsection
