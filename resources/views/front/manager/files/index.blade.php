@extends('layouts.app')

@section('title', 'Videos Details')

@section('content')

    @include('includes.front.navbar')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="container px-4">
                        @if(session()->has('success'))
                            <div class="alert alert-success text-center" role="alert">
                                {{ session('success') }}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger text-center" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>

                    <div class="text-center my-5">
                        <p class="d-inline fs-4">
                            Files Details
                            <a href="{{ route('file.add') }}" class="btn btn-outline-success mx-3">Add New</a>
                        </p>
                    </div>

                    @include('includes.admin.panel_filter')

                    <div class="scroll-bar overflow-scroll">
                        <table class="table bg-white">
                            <thead class="bg-light">
                            <tr>
                                <th>Name | Type</th>
                                <th>Size</th>
                                <th>Uploaded By</th>
                                <th>Sector | Line</th>
                                <th>Downloaded</th>
                                <th>Uploaded at</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($files->get()) > 0)
                                @if(isset($_GET['search']))
                                    @php($files = $files->where('files.name', 'like', '%' . $_GET['search'] . '%'))
                                @endif
                                @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                                    @php($files = $files->whereDate('files.created_at', $_GET['date'])->get())
                                @else
                                    @php($files = $files->get())
                                @endif
                                @foreach($files as $file)
                                    <tr>
                                        @php($file_type = "")
                                        @if (str_contains($file->type, 'word'))
                                            @php($file_type = "Word")
                                        @elseif (str_contains($file->type, 'excel'))
                                            @php($file_type = "Excel")
                                        @elseif (str_contains($file->type, 'pdf'))
                                            @php($file_type = "PDF")
                                        @elseif (str_contains($file->type, 'video'))
                                            @php($file_type = "Video")
                                        @elseif (str_contains($file->type, 'zip'))
                                            @php($file_type = "ZIP")
                                        @elseif (str_contains($file->type, 'jpg') || str_contains($file->type, 'jpeg'))
                                            @php($file_type = "Image/jpeg")
                                        @elseif (str_contains($file->type, 'png'))
                                            @php($file_type = "Image/png")
                                        @elseif (str_contains($file->type, 'gif'))
                                            @php($file_type = "Image/gif")
                                        @else
                                            @php($file_type = "file")
                                        @endif
                                        <td>
                                            <span>{{ $file->name . " | " }}</span>
                                            <span>{{ $file_type }}</span>
                                        </td>
                                        <td>{{ floor($file->size / 1000) < 1000 ?  floor($file->size / 1000) . ' K' :  floor($file->size / 1000 / 1000) . ' Mb' }}</td>
                                        <td>{{ ucfirst($file->user_name) }}</td>
                                        <td>
                                            <span>{{ $file->sector_name . " | " }}</span>
                                            <span>{{ $file->line_name }}</span>
                                        </td>
                                        <td>{{ $downloaded->where('file_id', $file->id)->count() }}</td>
                                        <td>{{ date('d-m-Y, h:m a', strtotime($file->created_at)) }}</td>
                                        <td>
                                            <form action="{{ route('toggle_show_file', $file->id) }}" method="post"
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit"
                                                        class="{{ $file->status ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                                    {{ $file->status ? 'Hide' : 'Show' }}
                                                </button>
                                            </form>
                                            <form action="{{ route('ea_files.destroy', $file->id) }}" method="post"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm btn-rounded">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                @include('includes.admin.empty_message')
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.front.footer')
    </div>

    @include('includes.front.scripts')

    <script src="{{ asset('assets/js/owl.carousel.js') }}"></script>
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
