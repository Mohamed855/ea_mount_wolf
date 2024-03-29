@extends('layouts.app')

@section('title', 'Add Video')

@section('content')

    @include('includes.front.navbar')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
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
                        <div id="video_err" class="alert alert-danger text-center m-auto mb-2 col-12 col-lg-8" role="alert" style="display:none;"></div>
                        <div id="video_success" class="alert alert-success text-center m-auto mb-2 col-12 col-lg-8" role="alert" style="display:none;"></div>
                    </div>
                    <div class="col-12 col-lg-8 m-auto">
                        <div class="overflow-scroll border bg-white shadow rounded-2 py-5 px-4 px-lg-5">
                            <h3 class="pb-4">Add New Video</h3>
                            <div class="loader-container" id="loaderContainer">
                                <div class="loader"></div>
                            </div>
                            <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-10 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="name" class="form-control py-2" value="{{ old('name') }}" placeholder="Video Name" required>
                                    </div>

                                    <div class="pb-3">
                                        <select class="form-control py-2" name="is_youtube" id="is_youtube">
                                            <option disabled selected>Select video type</option>
                                            <option value="0">Storage Video</option>
                                            <option value="1">Youtube Video</option>
                                        </select>
                                    </div>

                                    <div class="pb-3" id="youtube_link_container" style="display: none;">
                                        <input type="text" name="youtube_link" id="youtube_link" class="form-control py-2" value="{{ old('youtube_link') }}" placeholder="Youtube Link">
                                    </div>
                                    <div class="pb-3" id="video_container" style="display: none;">
                                        <input type="file" name="video" id="video" class="form-control py-2" accept=".mp4,.mov,.ogg" placeholder="Video File">
                                    </div>

                                    <div class="col-12 p-3 mt-2 mb-3 border rounded">
                                        <div class="row">
                                            <h6 class="text-start">Choose sector</h6>
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
                                            <h6 class="text-start">Choose sector</h6>
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
                                        <h6 class="text-start">Choose line</h6>
                                        <div class="col-12 text-start">
                                            <input type="checkbox" id="select_all_lines" name="select_all_lines" value="select_all_lines" style="cursor:pointer">
                                            <label class="small" for="select_all_lines">Select All</label>
                                        </div>
                                        @foreach($sectors as $sl)
                                            @php($integerSectorIds = array_map('intval', auth()->user()->sectors))
                                            <div id="{{ 'sl_' . $sl->id }}" style="display: {{ $sl->id == old('s_' . $sl->id) ? 'flex' : 'none' }}">
                                                @php($manager_lines = \App\Models\ManagerLines::query()
                                                    ->where('user_id', auth()->id())
                                                    ->whereIn('sector_id', $integerSectorIds)
                                                    ->get())

                                                <div class="col-12 p-3 mt-2 mb-3 border rounded">
                                                    <div class="row">
                                                        <h6 class="text-start">{{ $sl->name }}</h6>
                                                        @php($lines = \App\Models\Line::query()->get())
                                                        @for($i = 0; $i < count($manager_lines); $i++)
                                                            @foreach($lines as $line)
                                                                @if($manager_lines[$i]->sector_id == $sl->id && in_array($line->id, $manager_lines[$i]->lines))
                                                                    <div class="col-12 col-md-6 col-xxl-4 text-start">
                                                                        <input type="checkbox" name="{{ 's_' . $sl->id . 'l_' . $line->id }}" value="{{ $line->id }}" {{ $line->id == old('s_' . $sl->id . 'l_' . $line->id) ? 'checked' : '' }} style="cursor:pointer" class="line_checkbox">
                                                                        <label class="small" for="{{ 's_' . $sl->id . 'l_' . $line->id }}">{{ $line->name }}</label>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-10 col-12 m-auto">
                                    <button class="btn submit_btn p-2 my-3 w-100" onclick="uploadVideo()" id="submitButton">Add video</button>
                                    <span class="text-dark">Max size is 300 MB</span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.front.footer')
    </div>

    @include('includes.front.scripts')
    @include('includes.admin.scripts')
    @include('includes.admin.selectAllScripts')

    <script src="{{ asset('assets/js/owl.carousel.js') }}"></script>
    <script>
        let is_youtube = document.getElementById("is_youtube");
        let youtube_link = document.getElementById("youtube_link_container");
        let video = document.getElementById("video_container");

        is_youtube.addEventListener("change", function() {
            let value = is_youtube.value;
            if (value === "0") {
                youtube_link.style.display = "none";
                video.style.display = "block";
            } else if (value === "1") {
                youtube_link.style.display = "block";
                video.style.display = "none";
            }
        });
        function uploadVideo() {
            let fileInput = document.getElementById('video');
            let videoErr = document.getElementById('video_err');
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
                    formData.append("is_youtube", form.is_youtube.value);
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
                window.location.href = "{{ route('managerVideoStored') }}"
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
    <script>
        $(document).ready(function () {
            $("#topics-carousel").owlCarousel({
                margin: 30,
                autoplay: true,
                loop: true,
                autoplayHoverPause: true,
                responsive: {0: {items: 2,}, 600: {items: 3,}, 1000: {items: 4,}}
            });
        });
    </script>
@endsection
