@extends('layouts.panel')

@section('title', __('translate.aboutUs'))

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
                            <h3 class="pb-4">@lang('panel.addNew') @lang('translate.aboutUs')</h3>
                            <form action="{{ route('about.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-5 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <textarea name="title" id="" rows="4" class="form-control py-2" placeholder="@lang('panel.title')"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-5 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <textarea name="text" id="" rows="4" class="form-control py-2" placeholder="@lang('panel.text')"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-10 col-12 m-auto">
                                    <div class="pb-3">
                                        <input type="file" name="image" id="formFile" class="form-control py-2" value="{{ old('image') }}"  placeholder="@lang('panel.image')">
                                    </div>
                                </div>
                                <div class="col-md-10 col-12 m-auto">
                                    <button type="submit" class="btn submit_btn p-2 my-3 w-100">@lang('translate.add')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
