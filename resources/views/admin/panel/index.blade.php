@extends('layouts.panel')

@section('title', 'Overview')

@section('panel_title')
    Overview
@endsection

@section('panel_content')
    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row justify-content-between py-2">
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded bg-white col-12 col-md-5 col-lg-3">
                            <h3 class="rounded text-center fs-6">Announces</h3>
                            <span class="rounded fs-5">{{ $announcements_count }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded bg-white col-12 col-md-5 col-lg-3">
                            <h3 class="rounded text-center fs-6">Sectors</h3>
                            <span class="rounded fs-5">{{ $sectors_count }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded bg-white col-12 col-md-5 col-lg-3">
                            <h3 class="rounded text-center fs-6">Lines</h3>
                            <span class="rounded fs-5">{{ $lines_count }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded bg-white col-12 col-md-5 col-lg-3">
                            <h3 class="rounded text-center fs-6">Admins</h3>
                            <span class="rounded fs-5">{{ $admins_count }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded bg-white col-12 col-md-5 col-lg-3">
                            <h3 class="rounded text-center fs-6">Managers</h3>
                            <span class="rounded fs-5">{{ $managers_count }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded bg-white col-12 col-md-5 col-lg-3">
                            <h3 class="rounded text-center fs-6">Employees</h3>
                            <span class="rounded fs-5">{{ $employees_count }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded bg-white col-12 col-md-5 col-lg-3">
                            <h3 class="rounded text-center fs-6">Topics</h3>
                            <span class="rounded fs-5">{{ $topics_count }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded bg-white col-12 col-md-5 col-lg-3">
                            <h3 class="rounded text-center fs-6">Files</h3>
                            <span class="rounded fs-5">{{ $files_count }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded bg-white col-12 col-md-5 col-lg-3">
                            <h3 class="rounded text-center fs-6">Videos</h3>
                            <span class="rounded fs-5">{{ $videos_count }}</span>
                        </div>
                    </div>
                    <div class="row justify-content-between py-5">
                        @foreach($sectors as $sector)
                            <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded bg-white col-12 col-md-5 col-lg-3">
                                <h3 class="rounded text-center fs-6">{{ $sector->name }}</h3>
                                <span class="rounded fs-6">{{ 'Files: ' . $files->where('sector_id', $sector->id)->count() }}</span>
                                <br>
                                <span class="rounded fs-6">{{ 'Videos: ' . $videos->where('sector_id', $sector->id)->count() }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
