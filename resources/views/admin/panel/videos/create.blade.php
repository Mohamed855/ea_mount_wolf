@extends('layouts.panel')

@section('title', 'Add Video')

@section('panel_content')
    <div class="container px-4">
        <div id="video_err" class="alert alert-danger text-center m-auto mb-2 col-12 col-lg-8" role="alert" style="display:none;"></div>
        <div id="video_success" class="alert alert-success text-center m-auto mb-2 col-12 col-lg-8" role="alert" style="display:none;"></div>
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
                                <span id="progressText" class="position-absolute d-flex align-items-center justify-content-center top-0 bottom-0 start-0 end-0 text-center text-dark" style="font-size: 16px"></span>
                            </div>
                            <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data" id="videoForm">
                                @csrf
                                <div class="col-md-10 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="name" class="form-control py-2" value="{{ old('name') }}" placeholder="Video Name" required>
                                    </div>
                                    <div class="pb-3">
                                        <input type="file" name="video" id="video" class="form-control py-2" accept="video/*" placeholder="Video File" required>
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
                                    <button class="btn submit_btn p-2 my-3 w-100" onclick="uploadVideo()" id="submitButton">Add video</button>
                                    <span class="text-dark">Max size is 300 MB</span>
                                </div>
                            </form>
                            <script>
                                function uploadVideo() {
                                    let fileInput = document.getElementById('video');
                                    let videoErr = document.getElementById('video_err');
                                    let videoSuccess = document.getElementById('video_success');
                                    if (fileInput.files.length > 0) {
                                        let fileSizeMB = fileInput.files[0].size / (1024 * 1024);
                                        let maxFileSizeMB = 300;
                                        if (fileSizeMB > maxFileSizeMB) {
                                            videoErr.innerHTML = "The file is too big. Maximum allowed size is 300 MB.";
                                            videoErr.style.display = 'block';
                                            return false;
                                        }

                                        let form = document.getElementById("videoForm");
                                        form.addEventListener("submit", function(event) {
                                            event.preventDefault();

                                            let fileInput = form.querySelector("input[type=file]");
                                            let file = fileInput.files[0];
                                            let formData = new FormData();

                                            formData.append("video", file);
                                            formData.append("_token", form.querySelector("input[name=_token]").value);
                                            formData.append("name", form.name.value);
                                            for (let title of document.getElementsByClassName("title_checkbox")) {
                                                if (title.checked) {
                                                    formData.append(title.name, title.value);
                                                }
                                            }
                                            for (let sector of document.getElementsByClassName("sector_checkbox")) {
                                                if (sector.checked) {
                                                    formData.append(sector.name, sector.value);
                                                    for (let line of document.getElementsByClassName("line_checkbox")) {
                                                        if (line.checked && line.id.startsWith(sector.id)) {
                                                            formData.append(line.name, line.value);
                                                        }
                                                    }
                                                }
                                            }

                                            let xhr = new XMLHttpRequest();

                                            xhr.addEventListener("load", onLoad);
                                            xhr.addEventListener("error", onError);
                                            xhr.upload.addEventListener("progress", onProgress);

                                            xhr.open("POST", "{{ route('videos.store') }}");

                                            xhr.send(formData);
                                        });
                                    }

                                    function onLoad(event) {
                                        document.getElementById('loaderContainer').style.display = 'none';
                                        document.getElementById('submitButton').removeAttribute('disabled');
                                        videoSuccess.innerHTML = "Video added successfully";
                                        videoSuccess.style.display = 'block';
                                    }
                                    function onError(event) {
                                        videoErr.innerHTML = "An error occurred during the upload process";
                                        videoErr.style.display = 'block';
                                    }
                                    function onProgress(event) {
                                        document.getElementById('submitButton').setAttribute('disabled', 'disabled');
                                        document.getElementById('loaderContainer').style.display = 'flex';
                                        if (event.lengthComputable) {
                                            let loaded = event.loaded;
                                            let total = event.total;
                                            let percent = Math.round((loaded / total) * 100);
                                            document.getElementById('progressText').textContent = percent + '';
                                        }
                                    }
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
