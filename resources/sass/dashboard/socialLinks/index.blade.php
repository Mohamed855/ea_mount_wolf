@extends('layouts.panel')

@section('title', __('panel.socialLinks'))

@section('panel_title')
    @lang('panel.socialLinks')
    <a href="{{ route('social-links.create') }}" class="btn btn-outline-success mx-3">@lang('panel.addNew')</a>
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
                    <th>@lang('panel.link')</th>
                    <th>@lang('panel.status')</th>
                    <th>@lang('panel.latestUpdate')</th>
                    <th>@lang('panel.actions')</th>
                </tr>
            </thead>
            <tbody>
                @if(count($socialLinks) > 0)
                    @foreach($socialLinks as $link)
                        <tr>
                            <td>
                                <a href="{{ $link->link }}" style="color: blue;text-decoration: none;">{{ $link->name }}</a>
                            </td>
                            <td>
                                <span
                                    class="{{ $link->public ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                    {{ $link->public ? __('panel.activated') : __('panel.waiting') }}
                                </span>
                            </td>
                            <td>
                                {{ date('d-m-Y, h:m a', strtotime($link->updated_at)) }}
                            </td>
                            <td>
                                <a href="{{ route('social-links.edit', $link->id) }}"
                                   class="btn btn-outline-primary btn-sm btn-rounded">
                                    @lang('panel.edit')
                                </a>
                                <form action="{{ route('toggle_active', ['table' => 'socialLinks','id' => $link->id]) }}" method="post"
                                          class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="{{ $link->public ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                        {{ $link->public ? __('panel.deactivate') : __('panel.active') }}
                                    </button>
                                </form>
                                <form action="{{ route('social-links.destroy', $link->id) }}" method="post"
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
