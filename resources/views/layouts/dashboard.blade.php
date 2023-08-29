@extends('layouts.app')

@section('title', 'Employee Access - Dashboard')

@section('content')

    <div class="w-100">
        @include('sections.sidebar')
        <div class="content-wraper withnav col-9 col-md-10 col-xl-11 float-end ps-3">
            <div class="body-content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="brain-box-title mb-5">
                                <p class="d-inline fs-4">
                                    @yield('dashboard_title')
                                </p>
                            </div>
                            <div>
                                @yield('dashboard_content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

@endsection
