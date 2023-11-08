@extends('layouts.panel')

@section('title', __('panel.meals'))

@section('panel_title')
    @lang('panel.meals')
    <a href="{{ route('meals.create') }}" class="btn btn-outline-success mx-3">@lang('panel.addNew')</a>
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
    @include('includes.admin.panel_filter')
    <div class="scroll-bar overflow-scroll">
        <table class="table bg-white">
            <thead class="bg-light">
                <tr>
                    <th>@lang('panel.name')</th>
                    <th>@lang('panel.image')</th>
                    <th>@lang('panel.price')</th>
                    <th>@lang('panel.status')</th>
                    <th>@lang('panel.category_name')</th>
                    <th>@lang('panel.latestUpdate')</th>
                    <th>@lang('panel.actions')</th>
                </tr>
            </thead>
            <tbody>
                @if(count($meals->get()) > 0)
                    @if(isset($_GET['search']))
                        @php($meals = $meals->where('meals.name', 'like', '%' . $_GET['search'] . '%'))
                    @endif
                    @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                        @php($meals = $meals->whereDate('meals.created_at', $_GET['date'])
                            ->orwhereDate('meals.updated_at', $_GET['date'])->get())
                    @else
                        @php($meals = $meals->get())
                    @endif
                    @if(count($meals) > 0)
                        @foreach($meals as $meal)
                            <tr>
                                <td>
                                    {{ $meal->name }}
                                </td>
                                <td>
                                    @if($meal->image)
                                        <img src="{{ asset($meal->image) }}" style="max-width: 200px">
                                    @else
                                        @lang('panel.notExist')
                                    @endif
                                </td>
                                <td>
                                    {{ $meal->price }}
                                </td>
                                <td>
                                    <span
                                        class="{{ $meal->public ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                        {{ $meal->public ? __('panel.public') : __('panel.menuOnly') }}
                                    </span>
                                </td>
                                <td>
                                    {{ $meal->cat_name }}
                                </td>
                                <td>
                                    {{ date('d-m-Y, h:m a', strtotime($meal->updated_at)) }}
                                </td>
                                <td>
                                    <a href="{{ route('meals.edit', $meal->id) }}"
                                       class="btn btn-outline-primary btn-sm btn-rounded">
                                        @lang('panel.edit')
                                    </a>
                                    <form action="{{ route('toggle_active', ['table' => 'meal','id' => $meal->id]) }}" method="post"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="{{ $meal->public ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                            {{ $meal->public ? __('panel.menuOnly') : __('panel.public') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('meals.destroy', $meal->id) }}" method="post"
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
                @else
                    @include('includes.admin.empty_message')
                @endif
            </tbody>
        </table>
    </div>
@endsection
