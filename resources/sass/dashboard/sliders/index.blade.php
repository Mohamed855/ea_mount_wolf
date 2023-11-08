@extends('layouts.panel')

@section('title', __('panel.sliders'))

@section('panel_title')
    @lang('panel.sliders')
    <a href="{{ route('sliders.create') }}" class="btn btn-outline-success mx-3">@lang('panel.addNew')</a>
@endsection

@section('panel_content')
    @if(session()->has('success'))
        <div class="alert alert-success text-center" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger text-center" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="scroll-bar overflow-scroll">
        <table class="table bg-white">
            <thead class="bg-light">
                <tr>
                    <th>@lang('panel.title')</th>
                    <th>@lang('panel.text')</th>
                    <th>@lang('panel.image')</th>
                    <th>@lang('panel.status')</th>
                    <th>@lang('panel.latestUpdate')</th>
                    <th>@lang('panel.actions')</th>
                </tr>
            </thead>
            <tbody>
                @if(count($sliders) > 0)
                    @foreach($sliders as $slider)
                        <tr>
                            <td>
                                {{ $slider->title }}
                            </td>
                            <td>
                                {{ $slider->text }}
                            </td>
                            <td>
                                @if($slider->image)
                                    <img src="{{ asset($slider->image) }}" style="max-width: 200px">
                                @else
                                    @lang('panel.notExist')
                                @endif
                            </td>
                            <td>
                                <span
                                    class="{{ $slider->public ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                    {{ $slider->public ? __('panel.activated') : __('panel.waiting') }}
                                </span>
                            </td>
                            <td>
                                {{ date('d-m-Y, h:m a', strtotime($slider->updated_at)) }}
                            </td>
                            <td>
                                <a href="{{ route('sliders.edit', $slider->id) }}"
                                   class="btn btn-outline-primary btn-sm btn-rounded">
                                    @lang('panel.edit')
                                </a>
                                <form action="{{ route('toggle_active', ['table' => 'slider','id' => $slider->id]) }}" method="post"
                                      class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="{{ $slider->public ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                        {{ $slider->public ? __('panel.deactivate') : __('panel.active') }}
                                    </button>
                                </form>
                                <form action="{{ route('sliders.destroy', $slider->id) }}" method="post"
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm btn-rounded">
                                        @lang('panel.delete')
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
@endsection
