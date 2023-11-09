@extends('layouts.panel')

@section('title', __('panel.homeSections'))

@section('panel_title')
    @lang('panel.homeSections')
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
                    <th>@lang('panel.section')</th>
                    <th>@lang('panel.latestUpdate')</th>
                    <th>@lang('panel.actions')</th>
                </tr>
            </thead>
            <tbody>
                @if(count($sections) > 0)
                    @foreach($sections as $section)
                        <tr>
                            <td>
                                {{ $section->title }}
                            </td>
                            <td>
                                @if($section->text)
                                    <p class="para">
                                        {{ $section->text }}
                                    </p>
                                @else
                                    @lang('panel.notExist')
                                @endif
                            </td>
                            <td>
                                @if($section->image)
                                    <img src="{{ public_path($section->image) }}" style="width: 200px">
                                @else
                                    @lang('panel.notExist')
                                @endif
                            </td>
                            <td>
                                {{ $section->section }}
                            </td>
                            <td>
                                {{ date('d-m-Y, h:m a', strtotime($section->updated_at)) }}
                            </td>
                            <td>
                                <a href="{{ route('sections.edit', $section->id) }}"
                                   class="btn btn-outline-primary btn-sm btn-rounded">
                                    @lang('panel.edit')
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">@lang('panel.empty')</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
