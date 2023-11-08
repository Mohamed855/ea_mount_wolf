@extends('layouts.panel')

@section('title', __('panel.meals'))

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
                            <h3 class="pb-4">@lang('panel.edit') @lang('panel.meal')</h3>
                            <form action="{{ route('meals.update', $meal->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="col-md-5 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="name" class="form-control py-2" value="{{ $meal->name }}" placeholder="@lang('panel.name')">
                                    </div>
                                    <div class="pb-3">
                                        <select name="category" class="form-control">
                                            <option value="0" disabled>categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $meal->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5 col-12 d-inline-block">
                                    <div class="pb-3">
                                        <input type="text" name="price" class="form-control py-2" value="{{ $meal->price }}" placeholder="@lang('panel.price')">
                                    </div>
                                    <div class="pb-3">
                                        <input type="file" name="image" id="formFile" class="form-control py-2" value="{{ $meal->image }}"  placeholder="@lang('panel.image')">
                                    </div>
                                </div>
                                <div class="col-md-10 col-12 m-auto">
                                    <button type="submit" class="btn submit_btn p-2 my-3 w-100">@lang('translate.save')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
