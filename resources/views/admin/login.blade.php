@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
    <div class="content-wraper">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <div class="main-logo pb-4"><img src="{{ asset('images/logos/logo.png') }}" class="mw-100" alt=""></div>
                        @if(session()->has('invalid'))
                            <div class="m-auto">
                                <span class="text-danger" role="alert">{{ session()->get('invalid') }}</span>
                            </div>
                        @endif
                        <div class="ea-form">
                            <form action="{{ route('admin.check_credentials') }}" method="post">
                                @csrf
                                <div>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email">
                                    @error('email')
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
                                    <button type="submit" class="ea-btns light-btn">Log In</button>
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
@endsection
