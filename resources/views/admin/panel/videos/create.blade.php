@extends('layouts.panel')

@section('title', 'Add Video')

@section('panel_content')
    <div class="container px-4">
        @if(session()->has('success'))
            <div class="alert alert-success text-center m-auto mb-2 col-12 col-lg-8" role="alert">
                {{ session('success') }}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger text-center m-auto mb-2 col-12 col-lg-8" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <div id="video_err" class="alert alert-danger text-center m-auto mb-2 col-12 col-lg-8" role="alert" style="display:none;">
            The file is too big. Maximum allowed size is 300 MB
        </div>
    </div>
    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row text-center">
                    <div class="col-12 col-lg-8 m-auto">
                        <div class="overflow-scroll border bg-white shadow rounded-2 py-5 px-4 px-lg-5">
                            <h3 class="pb-4">Add New Video</h3>
                            <div class="loader-container" id="loaderContainer">
                                <div class="loader"></div>
                            </div>
                            <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data" id="videoForm">
                                @csrf
                                <div class="col-md-10 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="name" class="form-control py-2" value="{{ old('name') }}" placeholder="Video Name">
                                    </div>
                                    <div class="pb-3">
                                        <input type="file" name="video" id="video" class="form-control py-2" accept="video/*" placeholder="Video File">
                                    </div>

                                    <div class="col-12 p-3 mt-2 mb-3 border rounded">
                                        <div class="row">
                                            <h6 class="text-start d-flex">Choose titles</h6>
                                            <div class="col-12 text-start d-inline-block">
                                                <input type="checkbox" id="select_all_titles" name="select_all_titles"
                                                       value="select_all" checked style="cursor:pointer">
                                                <label class="small" for="select_all_titles">Select All</label>
                                            </div>
                                            @foreach($titles as $title)
                                                <div class="col-12 col-md-6 text-start">
                                                    <input type="checkbox" id="{{ 't_' . $title->id }}"
                                                           name="{{ 't_' . $title->id }}" value="{{ $title->id }}"
                                                           checked style="cursor:pointer" class="title_checkbox">
                                                    <label class="small"
                                                           for="{{ 't_' . $title->id }}">{{ $title->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-12 p-3 mt-2 mb-3 border rounded">
                                        <div class="row">
                                            <h6 class="text-start">Choose sectors</h6>
                                            <div class="col-12 text-start">
                                                <input type="checkbox" id="select_all_sectors" name="select_all_sectors" value="select_all_sectors" style="cursor:pointer">
                                                <label class="small" for="select_all_sectors">Select All</label>
                                            </div>
                                            @foreach($sectors as $sector)
                                                <div class="col-12 col-md-6 col-xxl-4 text-start">
                                                    <input type="checkbox" id="{{ 's_' . $sector->id }}" name="{{ 's_' . $sector->id }}" value="{{ $sector->id }}" {{ $sector->id == old('s_' . $sector->id) ? 'checked' : '' }} style="cursor:pointer" class="sector_checkbox" onchange="generateSectorLines({{ $sector->id }})">
                                                    <label class="small" for="{{ 's_' . $sector->id }}">{{ $sector->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-12 p-3 mb-3 border rounded">
                                        <div class="row">
                                            <h6 class="text-start">Choose lines</h6>
                                            <div class="col-12 text-start">
                                                <input type="checkbox" id="select_all_lines" name="select_all_lines" value="select_all_lines" style="cursor:pointer">
                                                <label class="small" for="select_all_lines">Select All</label>
                                            </div>
                                            @foreach($sectors as $sl)
                                                <div id="{{ 'sl_' . $sl->id }}" style="display: {{ $sl->id == old('s_' . $sl->id) ? 'flex' : 'none' }}">
                                                    @php($lines = \App\Models\Line::query()
                                                      ->join('line_sector as ls', 'ls.line_id', '=', 'lines.id')
                                                      ->where('ls.sector_id', $sl->id)
                                                      ->where('lines.status', 1)
                                                      ->select(['lines.id', 'lines.name'])
                                                      ->orderBy('lines.id')->get()
                                                    )
                                                    <div class="col-12 p-3 mt-2 mb-3 border rounded">
                                                        <div class="row">
                                                            <h6 class="text-start">{{ $sl->name }}</h6>
                                                            @foreach($lines as $line)
                                                                <div class="col-12 col-md-6 col-xxl-4 text-start">
                                                                    <input type="checkbox" id="{{ 's_' . $sl->id . 'l_' . $line->id }}" name="{{ 's_' . $sl->id . 'l_' . $line->id }}" value="{{ $line->id }}" {{ $line->id == old('s_' . $sl->id . 'l_' . $line->id) ? 'checked' : '' }} style="cursor:pointer" class="line_checkbox">
                                                                    <label class="small" for="{{ 's_' . $sl->id . 'l_' . $line->id }}">{{ $line->name }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10 col-12 m-auto">
                                    <button class="btn submit_btn p-2 my-3 w-100" onclick="checkFileSize()" id="submitButton">Add video</button>
                                    <span class="text-dark">Max size is 300 MB</span>
                                </div>
                            </form>
                            <script>
                                function checkFileSize() {
                                    let fileInput = document.getElementById('video');
                                    let videoErr = document.getElementById('video_err');
                                    if (fileInput.files.length > 0) {
                                        let fileSizeMB = fileInput.files[0].size / (1024 * 1024);
                                        let maxFileSizeMB = 300;
                                        if (fileSizeMB > maxFileSizeMB) {
                                            videoErr.style.display = 'block';
                                            return;
                                        }
                                    }
                                    document.getElementById('videoForm').addEventListener('submit', function () {
                                        document.getElementById('loaderContainer').style.display = 'flex';
                                        document.getElementById('submitButton').setAttribute('disabled', 'disabled');
                                    });
                                    document.getElementById('videoForm').submit();
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.admin.scripts')
    @include('includes.admin.selectAllScripts')
@endsection
