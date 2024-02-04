@extends('layouts.app')

@section('title', 'Credentials')

@section('content')
    <div class="content-wraper">
        <div class="body-content" style="align-items:center;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8">
                        <div class="main-logo"><img src="{{ asset('storage/images/logos/logo.png') }}" class="mw-100" alt=""></div>
                        @if(session()->has('error'))
                            <div class="alert alert-danger text-center m-auto mb-2 col-12" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="ea-form">
                            <div class="border bg-white shadow rounded-2 py-5 px-4 px-lg-5">
                                <table class="w-100 m-auto">
                                    <div class="welcome">Welcomes Back {{ auth()->user()->first_name }}</div>
                                    <tbody>
                                        <tr>
                                            <td class="w-50 text-start p-1">Email:</td>
                                            <td class="w-50 text-start p-1">{{ auth()->user()->email }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-50 text-start p-1">CRM Code:</td>
                                            <td class="w-50 text-start p-1">{{ auth()->user()->crm_code }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-50 text-start p-1">Password:</td>
                                            <td class="w-50 text-start p-1">{{ $userPassword ? $userPassword->password : '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-12 m-auto my-3">
                                    <a href="{{ route('home') }}" class="btn btn-outline-success p-2 w-100">Go to homepage</a>
                                </div>
                                <div class="col-12 m-auto">
                                    <a href="{{ route('credentials.download', auth()->id()) }}" class="btn submit_btn p-2 w-100">Download Credentials</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @include('includes.front.logoFooter')
    </div>
    @include('includes.front.scripts')
@endsection
