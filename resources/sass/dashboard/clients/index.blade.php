@extends('layouts.panel')

@section('title', __('panel.clients'))

@section('panel_title')
    @lang('panel.clients')
    <a href="{{ route('clients.create') }}" class="btn btn-outline-success mx-3">@lang('panel.addNew')</a>
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
                    <th>@lang('panel.status')</th>
                    <th>@lang('panel.latestUpdate')</th>
                    <th>@lang('panel.actions')</th>
                </tr>
            </thead>
            <tbody>
                @if(count($clients->get()) > 0)
                    @if(isset($_GET['search']))
                        @php($clients = $clients->where('clients.name', 'like', '%' . $_GET['search'] . '%'))
                    @endif
                    @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                        @php($clients = $clients->whereDate('clients.created_at', $_GET['date'])
                            ->orwhereDate('clients.updated_at', $_GET['date'])->get())
                    @else
                        @php($clients = $clients->get())
                    @endif
                    @if(count($clients) > 0)
                        @foreach($clients as $client)
                            <tr>
                                <td>
                                    {{ $client->name }}
                                </td>
                                <td>
                                    @if($client->image)
                                        <img src="{{ public_path($client->image) }}" style="max-width: 200px">
                                    @else
                                        @lang('panel.notExist')
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="{{ $client->public ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                        {{ $client->public ? __('panel.activated') : __('panel.waiting') }}
                                    </span>
                                </td>
                                <td>
                                    {{ date('d-m-Y, h:m a', strtotime($client->updated_at)) }}
                                </td>
                                <td>
                                    <a href="{{ route('clients.edit', $client->id) }}"
                                       class="btn btn-outline-primary btn-sm btn-rounded">
                                        @lang('panel.edit')
                                    </a>
                                    <form action="{{ route('toggle_active', ['table' => 'client','id' => $client->id]) }}" method="post"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="{{ $client->public ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                            {{ $client->public ? __('panel.deactivate') : __('panel.active') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('clients.destroy', $client->id) }}" method="post"
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
