@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="content-wraper">
        <div class="body-content" style="align-items:center;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <div class="main-logo"><img src="{{ asset('images/logos/logo.png') }}" class="mw-100" alt=""></div>
                        <div class="welcome">Reset your password via email</div>
                        @if(session()->has('invalid'))
                            <div class="m-auto">
                                <span class="text-danger" role="alert">{{ session()->get('invalid') }}</span>
                            </div>
                        @elseif(session()->has('activeRequest'))
                            <div class="m-auto">
                                <span class="text-primary" role="alert">{{ session()->get('activeRequest') }}</span>
                            </div>
                        @endif
                        <div class="ea-form">
                            <form action="{{ route('reset_password_credentials') }}" method="post">
                                @csrf
                                <div>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email">
                                    @error('email')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <input type="text" name="crm_code" class="form-control @error('crm_code') is-invalid @enderror" value="{{ old('crm_code') }}" placeholder="CRM Code">
                                    @error('crm_code')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-btns">
                                    <button type="submit" class="ea-btns light-btn">Send a reset email</button>
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
