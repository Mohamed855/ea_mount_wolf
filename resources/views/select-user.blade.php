@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="content-wraper">
        <div class="body-content" style="align-items:center;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <div class="main-logo"><img src="{{ asset('storage/images/logos/logo.png') }}" class="mw-100" alt=""></div>
                        @if(session()->has('error'))
                            <div class="alert alert-borderless alert-danger text-center mb-2 mx-2" role="alert">
                                {{ session('error') }}
                            </div>
                        @elseif(session()->has('success'))
                            <div class="alert alert-borderless alert-success text-center mb-2 mx-2" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="welcome">Login As</div>
                        <div class="form-btns">
                            <a href="{{ route('employee.login') }}" class="ea-btns dark-btn text-center" style="text-decoration:none">Employee</a>
                            <a href="{{ route('manager.login') }}" class="ea-btns dark-btn text-center" style="text-decoration:none">Manager</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.front.logoFooter')
    </div>
    @include('includes.front.scripts')
@endsection
