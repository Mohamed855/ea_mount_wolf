@extends('layouts.panel')

@section('title', __('panel.categories'))

@section('panel_title')
    @lang('panel.categories')
    <a href="{{ route('categories.create') }}" class="btn btn-outline-success mx-3">@lang('panel.addNew')</a>
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
                    <th>@lang('panel.taps')</th>
                    <th>@lang('panel.latestUpdate')</th>
                    <th>@lang('panel.actions')</th>
                </tr>
            </thead>
            <tbody>
                @if(count($categories->get()) > 0)
                    @if(isset($_GET['search']))
                        @php($categories = $categories->where('categories.name', 'like', '%' . $_GET['search'] . '%'))
                    @endif
                    @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                        @php($categories = $categories->whereDate('categories.created_at', $_GET['date'])
                            ->orwhereDate('categories.updated_at', $_GET['date'])->get())
                    @else
                        @php($categories = $categories->get())
                    @endif
                    @if(count($categories) > 0)
                        @foreach($categories as $category)
                            <tr>
                                <td>
                                    {{ $category->name }}
                                </td>
                                <td>
                                    @if($category->taps)
                                        @foreach($category->taps as $tap)
                                            @if($tap == 1)
                                                @lang('translate.title') <br>
                                            @elseif($tap == 2)
                                                @lang('translate.menus')<span> VIP</span> <br>
                                            @else
                                                @lang('translate.menus') <br>
                                            @endif
                                        @endforeach
                                    @else
                                        @lang('panel.notExist')
                                    @endif
                                </td>
                                <td>
                                    {{ date('d-m-Y, h:m a', strtotime($category->updated_at)) }}
                                </td>
                                <td>
                                    <a href="{{ route('categories.edit', $category->id) }}"
                                       class="btn btn-outline-primary btn-sm btn-rounded">
                                        @lang('panel.edit')
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="post"
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
