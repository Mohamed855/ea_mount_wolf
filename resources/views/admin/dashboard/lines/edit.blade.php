@extends('layouts.app')

@section('title', 'Edit ' . $selected_line->name)

@section('content')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="brain-box-title pb-3">
                            <h3 class="d-inline">{{ 'Edit ' . $selected_line->name }}</h3>
                        </div>
                        <div class="col-lg-7 m-auto">
                            <form action="{{ route('lines.update', $selected_line->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="col-lg-6 m-auto py-2">
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $selected_line->name }}" placeholder="Line Name">
                                    @error('name')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label for="sectors[]">Sectors *</label>
                                <div class="col-lg-6 m-auto py-2">
                                    <select name="sectors[]" class="form-control @error('sectors[]') is-invalid @enderror" multiple="multiple">
                                        @foreach($sectors as $sector)
                                            <option value="{{ $sector->id }}"
                                            @foreach($selected_sectors as $selected_sector)
                                                {{ $selected_sector->sector_id == $sector->id ? 'selected' : '' }}
                                                @endforeach
                                            >{{ $sector->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sectors[]')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                                @if(session()->has('savedSuccessfully'))
                                    <div class="m-auto">
                                        <span class="text-primary" role="alert">{{ session()->get('savedSuccessfully') }}</span>
                                    </div>
                                @endif
                                <button type="submit" class="btn btn-outline-primary p-2 my-2 mx-lg-2">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
