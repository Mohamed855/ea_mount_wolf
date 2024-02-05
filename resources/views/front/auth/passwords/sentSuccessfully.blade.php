@extends('layouts.app')

@section('title', 'Email sent successfully')

@section('content')
    <div class="content-wraper">
        <div class="body-content" style="align-items:center;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <div class="main-logo"><img src="{{ asset('storage/images/logos/logo.png') }}" class="mw-100" alt=""></div>
                        @if($success)
                            <div class="py-3 fs-5">
                                <div class="alert alert-borderless alert-success text-center mb-2 mx-2" role="alert">
                                    {{ $success }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @include('includes.front.logoFooter')
    </div>
    @include('includes.front.scripts')
@endsection
