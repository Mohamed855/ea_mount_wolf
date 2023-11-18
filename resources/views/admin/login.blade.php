@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
    <div class="content-wraper">
        <div class="body-content" style="align-items:center;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <div class="main-logo pb-4"><img src="{{ asset('storage/images/logos/logo.png') }}" class="mw-100" alt=""></div>
                        @if(session()->has('error'))
                            <div class="alert alert-danger text-center m-auto mb-2 col-12" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="ea-form">
                            <form action="{{ route('admin.check_credentials') }}" method="post">
                                @csrf
                                <div>
                                    <input type="email" name="email" class="form-control py-2" value="{{ old('email') }}" placeholder="Email">
                                </div>
                                <div>
                                    <input type="password" name="password" class="form-control py-2" placeholder="Password">
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
