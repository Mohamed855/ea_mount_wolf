@extends('layouts.panel')

@section('title', __('translate.aboutUs'))

@section('panel_title')
    @lang('translate.aboutUs')
    <a href="{{ route('about.create') }}" class="btn btn-outline-success mx-3">@lang('panel.addNew')</a>
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
                @if(count($about) > 0)
                    @foreach($about as $ab)
                        <tr>
                            <td>
                                {{ $ab->title }}
                            </td>
                            <td>
                                @if($ab->text)
                                    <p class="para">
                                        {{ $ab->text }}
                                    </p>
                                @else
                                    @lang('panel.notExist')
                                @endif
                            </td>
                            <td>
                                @if($ab->image)
                                    <img src="{{ public_path($ab->image) }}" style="max-width: 200px">
                                @else
                                    @lang('panel.notExist')
                                @endif
                            </td>
                            <td>
                                <span
                                    class="{{ $ab->public ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                    {{ $ab->public ? __('panel.activated') : __('panel.waiting') }}
                                </span>
                            </td>
                            <td>
                                {{ date('d-m-Y, h:m a', strtotime($ab->updated_at)) }}
                            </td>
                            <td>
                                <a href="{{ route('about.edit', $ab->id) }}"
                                   class="btn btn-outline-primary btn-sm btn-rounded">
                                    @lang('panel.edit')
                                </a>
                                <form action="{{ route('toggle_active', ['table' => 'about','id' => $ab->id]) }}" method="post"
                                      class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="{{ $ab->public ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                        {{ $ab->public ? __('panel.deactivate') : __('panel.active') }}
                                    </button>
                                </form>
                                <form action="{{ route('about.destroy', $ab->id) }}" method="post"
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
