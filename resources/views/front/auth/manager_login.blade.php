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
                            <div class="alert alert-danger text-center m-auto mb-2 col-12" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="ea-form">
                            <form action="{{ route('manager.check_credentials') }}" method="post">
                                @csrf
                                <div>
                                    <input type="text" name="user_name" class="form-control py-2" value="{{ old('user_name') }}" placeholder="User Name or Email">
                                </div>
                                <div>
                                    <input type="text" name="crm_code" class="form-control py-2" value="{{ old('crm_code') }}" placeholder="CRM Code">
                                </div>
                                <div>
                                    <input type="password" name="password" class="form-control py-2" placeholder="Password">
                                </div>
                                <div class="form-btns">
                                    <button type="submit" class="ea-btns dark-btn">Log In</button>
                                </div>
                                <div class="form-btns pt-3">
                                    <a href="{{ route('password.request') }}" class="btn-link text-decoration-none">Forget password</a>
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
