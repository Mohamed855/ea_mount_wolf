@extends('views.layouts.panel')

@section('title', __('panel.info'))

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
                            <h3 class="pb-2">@lang('panel.edit') @lang('panel.info')</h3>
                            <form action="{{ route('info.update', 'details') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="col-md-10 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="address" class="form-control py-2"
                                               value="{{ $info->address }}" placeholder="@lang('panel.address')">
                                    </div>
                                </div>
                                <div class="col-md-5 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="phone" class="form-control py-2"
                                               value="{{ $info->phone }}" placeholder="@lang('panel.phone')">
                                    </div>
                                </div>
                                <div class="col-md-5 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="whatsapp_number" class="form-control py-2"
                                               value="{{ $info->whatsapp_number }}"
                                               placeholder="@lang('panel.whatsappNumber')">
                                    </div>
                                </div>
                                <div class="col-md-10 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="location" class="form-control py-2"
                                               value="{{ $info->location }}"
                                               placeholder="=https://www.google.com/maps/embed?pb">
                                    </div>
                                </div>
                                <div class="col-md-10 col-12 m-auto">
                                    <div class="map-wraper">
                                        <iframe src="{{ $info->location }}" width="100%" height="220"></iframe>
                                    </div>
                                </div>
                                <div class="col-md-10 col-12 m-auto">
                                    <button type="submit"
                                            class="btn submit_btn p-2 mt-3 w-100">@lang('translate.save')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
