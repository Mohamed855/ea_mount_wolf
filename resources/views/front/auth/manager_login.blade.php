@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="content-wraper">
        <div class="body-content" style="align-items:center;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <div class="main-logo"><img src="{{ asset('storage/images/logos/logo.png') }}" class="mw-100" alt=""></div>
                        <div class="welcome">Welcome to Averroes Manager Access</div>
                        @if(session()->has('error'))
                            <div class="m-auto">
                                <span class="text-danger" role="alert">{{ session()->get('invalid') }}</span>
                            </div>
                        @endif
                        <div class="ea-form">
                            <form action="{{ route('manager.check_credentials') }}" method="post">
                                @csrf
                                <div>
                                    <input type="text" name="user_name" class="form-control @error('user_name') is-invalid @enderror" value="{{ old('user_name') }}" placeholder="User Name or Email">
                                    @error('user_name')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <input type="text" name="crm_code" class="form-control @error('crm_code') is-invalid @enderror" value="{{ old('crm_code') }}" placeholder="CRM Code">
                                    @error('crm_code')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                                    @error('password')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-btns">
                                    <button type="submit" class="ea-btns dark-btn">Log In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @include('includes.front.logoFooter')
    </div>
    @include('includes.front.scripts')
@endsection
