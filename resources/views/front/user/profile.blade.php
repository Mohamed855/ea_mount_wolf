@extends('layouts.app')

@section('title', auth()->user()->first_name . '\'s profile')

@section('content')

    @include('includes.front.navbar')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="mb-4">
                            <div class="profile-pic bg-styles m-auto mb-2"
                                 style="background-image:url({{
                            auth()->user()->profile_image == null ?
                            asset('storage/images/profile_images/default_profile_image.jpg') :
                            asset('storage/images/profile_images/'.auth()->user()->profile_image)
                             }}); width: 120px;  height: 120px">
                            </div>

                            <div>
                                @if(session()->has('success'))
                                    <div class="m-auto">
                                        <span class="text-primary"
                                              role="alert">{{ session()->get('success') }}</span>
                                    </div>
                                @elseif(session()->has('success'))
                                    <div class="m-auto">
                                        <span class="text-danger"
                                              role="alert">{{ session()->get('success') }}</span>
                                    </div>
                                @endif

                                @if(auth()->user()->profile_image == null)
                                    <div>
                                        <form action="{{ route('profile_picture.update') }}" id="profile_picture_form"
                                              method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <label class="btn btn-sm btn-outline-primary btn-rounded">
                                                <input type="file" name="profile_picture" id="profile_picture"
                                                       accept=".png,.jpg">
                                                Upload
                                            </label>
                                        </form>
                                    </div>
                                @else
                                    <div>
                                        <form action="{{ route('profile_picture.update') }}" id="profile_picture_form"
                                              method="post" enctype="multipart/form-data" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <label class="btn btn-sm btn-outline-primary btn-rounded">
                                                <input type="file" name="profile_picture" id="profile_picture"
                                                       accept=".png,.jpg">
                                                Change
                                            </label>
                                        </form>
                                        <form action="{{ route('profile_picture.delete') }}" method="post"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm btn-rounded">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="pb-3">
                            <h5 class="text-center">{{ auth()->user()->role == 1 ? ucfirst(auth()->user()->first_name) : ucfirst(auth()->user()->first_name) . ' ' . ucfirst(auth()->user()->middle_name) . ' ' . ucfirst(auth()->user()->last_name) }}</h5>
                            <hr class="col-4 m-auto">
                        </div>

                        <div class="d-table m-auto">
                            <div class="d-table-row">
                                <div class="profile_details d-table-cell text-end">User name :</div>
                                <div class="d-table-cell text-start px-2">{{ auth()->user()->role == 1 ? ucfirst(auth()->user()->first_name) : ucfirst(auth()->user()->user_name) }}</div>
                            </div>
                            <div class="d-table-row">
                                <div class="profile_details d-table-cell text-end">Email :</div>
                                <div class="d-table-cell text-start px-2">{{ auth()->user()->email }}</div>
                            </div>
                            <div class="d-table-row">
                                <div class="profile_details d-table-cell text-end">CRM Code :</div>
                                <div class="d-table-cell text-start px-2">{{ auth()->user()->role == 1 ? '_____' : auth()->user()->crm_code }}</div>
                            </div>
                            <div class="d-table-row">
                                <div class="profile_details d-table-cell text-end">Phone Number :</div>
                                <div class="d-table-cell text-start px-2">{{ auth()->user()->role == 1 ? '_____' : auth()->user()->phone_number }}</div>
                            </div>
                            <div class="d-table-row">
                                <div class="profile_details d-table-cell text-end">Title :</div>
                                <div class="d-table-cell text-start px-2">{{ auth()->user()->role == 1 ? '_____' : $user_details->title_name }}</div>
                            </div>
                        </div>
                        <div class="m-auto pt-3">
                            <a href="{{ route('password.change') }}" class="btn btn-sm btn-outline-primary btn-rounded">
                                Change Password
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('includes.front.footer')
    </div>

    @include('includes.front.scripts')

    <script>
        document.getElementById('profile_picture').addEventListener('change', function () {
            document.getElementById('profile_picture_form').submit();
        });
    </script>

@endsection
