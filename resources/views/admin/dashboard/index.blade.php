@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('dashboard_title')
    Overview
@endsection

@section('dashboard_content')
    <div class="body-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="row justify-content-between m-auto">
                        <div class="py-4 px-4 mb-5 rounded dashboard_info" style="max-width: 160px">
                            <h4 class="rounded text-center fs-6">Announces</h4>
                            <span class="rounded text-center fs-5">{{ $announcements_count }}</span>
                        </div>
                        <div class="py-4 px-4 mb-5 rounded dashboard_info" style="max-width: 160px">
                            <h4 class="rounded text-center fs-6">Sectors</h4>
                            <span class="rounded text-center fs-5">{{ $sectors_count }}</span>
                        </div>
                        <div class="py-4 px-4 mb-5 rounded dashboard_info" style="max-width: 160px">
                            <h4 class="rounded text-center fs-6">Lines</h4>
                            <span class="rounded text-center fs-5">{{ $lines_count }}</span>
                        </div>
                        <div class="py-4 px-4 mb-5 rounded dashboard_info" style="max-width: 160px">
                            <h4 class="rounded text-center fs-6">Users</h4>
                            <span class="rounded text-center fs-5">{{ $users_count }}</span>
                        </div>
                        <div class="py-4 px-4 mb-5 rounded dashboard_info" style="max-width: 160px">
                            <h4 class="rounded text-center fs-6">Topics</h4>
                            <span class="rounded text-center fs-5">{{ $topics_count }}</span>
                        </div>
                        <div class="py-4 px-4 mb-5 rounded dashboard_info" style="max-width: 160px">
                            <h4 class="rounded text-center fs-6">Files</h4>
                            <span class="rounded text-center fs-5">{{ $files_count }}</span>
                        </div>
                        <div class="py-4 px-4 mb-5 rounded dashboard_info" style="max-width: 160px">
                            <h4 class="rounded text-center fs-6">Videos</h4>
                            <span class="rounded text-center fs-5">{{ $videos_count }}</span>
                        </div>
                    </div>
                    <div class="row justify-content-between m-auto">
                        @foreach($sectors as $sector)
                            <div class="py-4 px-4 mb-5 rounded dashboard_info" style="max-width: 160px">
                                <h4 class="rounded text-center fs-6">{{ $sector->name }}</h4>
                                <span class="rounded text-center fs-6">{{ 'Files: ' . $files->where('sector_id', $sector->id)->count() }}</span>
                                <br>
                                <span class="rounded text-center fs-6">{{ 'Videos: ' . $videos->where('sector_id', $sector->id)->count() }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="row justify-content-between m-auto">
                        <div class="py-4 px-4 mb-5 rounded dashboard_info col-5">
                            <h4 class="rounded text-center fs-6">Files Downloads</h4>
                            <span class="rounded text-center fs-5">{{ $file_downloads_count }}</span>
                        </div>
                        <div class="py-4 px-4 mb-5 rounded dashboard_info col-5">
                            <h4 class="rounded text-center fs-6">Videos Views</h4>
                            <span class="rounded text-center fs-5">{{ $video_views_count }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
