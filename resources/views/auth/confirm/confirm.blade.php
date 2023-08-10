@extends('layouts.app')

@section('title', 'confirm')

@section('content')
    <div class="content-wraper">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <div class="welcome-box">
                            <h4>Welcome to Averroes Ground Rules</h4>
                            <p>You're receiving this message because you recently Signed up for a Averroes Ground Rules.</p>
                            <p>Confirm your email address by checking the batten below. this  step adds extra security to your business by verifying you this email</p>
                            <a href="#" class="ea-btns btn-confirm margin-top-30">Confirm email</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('sections.logoFooter')
    </div>

    @include('sections.scripts')
@endsection
