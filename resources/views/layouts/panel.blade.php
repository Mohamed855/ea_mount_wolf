@extends('layouts.admin')

@section('content')
    @include('includes.admin.navbar')

    <div>
        <main class="pb-5">
            <div class="w-100">
                <div class="side_bar text-center col-4 col-md-3 col-lg-2">
                    @include('includes.admin.sidebar')
                </div>
                <div class="panel-content col-8 col-md-9 col-lg-10">
                    <div class="body-content">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="text-center my-5">
                                        <p class="d-inline fs-4">
                                            @yield('panel_title')
                                        </p>
                                    </div>
                                    <div class="panel">
                                        @yield('panel_content')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

@endsection
