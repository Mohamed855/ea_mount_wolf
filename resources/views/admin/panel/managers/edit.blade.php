@extends('layouts.panel')

@section('title', 'Edit ' . ucfirst($selected_manager->user_name))

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
    </div>
    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row text-center">
                    <div class="col-12 col-lg-8 m-auto">
                        <div class="overflow-scroll border bg-white shadow rounded-2 py-5 px-4 px-lg-5">
                            <h3 class="pb-4">{{ 'Edit ' . ucfirst($selected_manager->user_name) }}</h3>
                            <div class="m-auto">
                                <form action="{{ route('managers.update', $selected_manager->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-10 col-12 m-auto row">
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="first_name" class="form-control py-2" value="{{ $selected_manager->first_name }}" placeholder="First Name">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="middle_name" class="form-control py-2" value="{{ $selected_manager->middle_name }}" placeholder="Middle Name">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="last_name" class="form-control py-2" value="{{ $selected_manager->last_name }}" placeholder="Last Name">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="user_name" class="form-control py-2" value="{{ $selected_manager->user_name }}" placeholder="User Name">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="email" class="form-control py-2" value="{{ $selected_manager->email }}" placeholder="Email">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="crm_code" class="form-control py-2" value="{{ $selected_manager->crm_code }}" placeholder="CRM Code">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="phone_number" class="form-control py-2" value="{{ $selected_manager->phone_number }}" placeholder="Phone Number">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <select name="title" class="form-control py-2">
                                                <option value="0" disabled>Title *</option>
                                                @foreach($titles as $title)
                                                    <option value="{{ $title->id }}" {{ $title->id == $selected_manager->title_id ? 'selected' : '' }}>{{ $title->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <select name="sectors[]" class="form-control py-2" multiple>
                                                <option value="0" disabled>Sector *</option>
                                                @foreach($sectors as $sector)
                                                    <option value="{{ $sector->id }}" {{ in_array($sector->id, $integerSectorIds) ? 'selected' : '' }}>{{ $sector->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <select name="lines[]" class="form-control py-2" multiple>
                                                <option value="0" disabled>Line *</option>
                                                @foreach($lines as $line)
                                                    <option value="{{ $line->id }}" {{ in_array($line->id, $integerLineIds) ? 'selected' : '' }}>{{ $line->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-12 m-auto">
                                        <button type="submit" class="btn submit_btn p-2 my-3 w-100">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
