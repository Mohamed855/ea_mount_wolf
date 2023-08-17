@extends('layouts.app')

@section('title', 'Employee Access - Dashboard')

@section('content')

    @include('sections.nav')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="brain-box-title pb-5 mb-5">
                            <h3 class="d-inline">Dashboard</h3>
                        </div>
                        <div class="row buttons justify-content-between m-auto">
                            <a href="{{ route('announcements.index') }}" class="py-5 px-4 mb-5 control-btn text-decoration-none rounded" style="max-width: 200px;">
                                <span class="rounded text-center text-white fs-5">Announcements</span>
                            </a>
                            <a href="{{ route('sectors.index') }}" class="py-5 px-4 mb-5 control-btn text-decoration-none rounded" style="max-width: 200px;">
                                <span class="rounded text-center text-white fs-5">Sectors</span>
                            </a>
                            <a href="{{ route('lines.index') }}" class="py-5 px-4 mb-5 control-btn text-decoration-none rounded" style="max-width: 200px;">
                                <span class="rounded text-center text-white fs-5">Lines</span>
                            </a>
                            <a href="{{ route('users.index') }}" class="py-5 px-4 mb-5 control-btn text-decoration-none rounded" style="max-width: 200px;">
                                <span class="rounded text-center text-white fs-5">Users</span>
                            </a>
                            <a href="{{ route('ea_topics.index') }}" class="py-5 px-4 mb-5 control-btn text-decoration-none rounded" style="max-width: 200px;">
                                <span class="rounded text-center text-white fs-5">Topics</span>
                            </a>
                            <a href="{{ route('ea_files.index') }}" class="py-5 px-4 mb-5 control-btn text-decoration-none rounded" style="max-width: 200px;">
                                <span class="rounded text-center text-white fs-5">Files</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection