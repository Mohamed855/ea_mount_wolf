@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="content-wraper">
        <div class="body-content" style="align-items:center;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <div class="main-logo"><img src="{{ asset('storage/images/logos/logo.png') }}" class="mw-100" alt=""></div>
                        <div class="welcome">Enter the new password<br><span class="fs-6">make sure that the password is strong and could be remembered</span></div>
                        @if(session()->has('error'))
                            <div class="alert alert-danger text-center m-auto mb-2 col-12" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="ea-form">
                            <form action="{{ route('password.save') }}" method="post">
                                @csrf
                                <input id="email" type="hidden" name="email" value="{{ $email ?? old('email') }}" required>
                                <input id="token" type="hidden" name="token" value="{{ $token ?? old('token') }}" required>
                                <div>
                                    <input type="password" name="password" class="form-control py-2" placeholder="Password">
                                </div>
                                <div>
                                    <input type="password" name="password_confirmation" class="form-control py-2" placeholder="Confirm password">
                                </div>
                                <div class="form-btns">
                                    <button type="submit" class="ea-btns dark-btn">Save</button>
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
