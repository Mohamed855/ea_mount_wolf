@extends('layouts.panel')

@section('title', __('panel.orders'))

@section('panel_title')
    @lang('panel.orders')
    <a href="{{ route('orders.create') }}" class="btn btn-outline-success mx-3">@lang('panel.addNew')</a>
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
                    <th>@lang('panel.email')</th>
                    <th>@lang('panel.company')</th>
                    <th>@lang('panel.phone')</th>
                    <th>@lang('panel.order')</th>
                    <th>@lang('panel.status')</th>
                    <th>@lang('panel.orderedAt')</th>
                    <th>@lang('panel.actions')</th>
                </tr>
            </thead>
            <tbody>
                @if(count($orders->get()) > 0)
                    @if(isset($_GET['search']))
                        @php($orders = $orders->where('orders.name', 'like', '%' . $_GET['search'] . '%')
                            ->orwhere('orders.email', 'like', '%' . $_GET['search'] . '%')
                            ->orwhere('orders.company', 'like', '%' . $_GET['search'] . '%')
                            ->orwhere('orders.phone', 'like', '%' . $_GET['search'] . '%'))
                    @endif
                    @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                        @php($orders = $orders->whereDate('orders.created_at', $_GET['date'])
                            ->orwhereDate('orders.updated_at', $_GET['date'])->get())
                    @else
                        @php($orders = $orders->get())
                    @endif
                    @if(count($orders) > 0)
                        @foreach($orders as $order)
                            <tr>
                                <td>
                                    {{ $order->name }}
                                </td>
                                <td>
                                    {{ $order->email }}
                                </td>
                                <td>
                                    {{ $order->company }}
                                </td>
                                <td>
                                    {{ $order->phone }}
                                </td>
                                <td>
                                    <p class="para text-center">
                                        {{ $order->order }}
                                    </p>
                                </td>
                                <td>
                                    <span
                                        class="{{ $order->viewed ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                        {{ $order->viewed ? __('panel.responded') : __('panel.waiting') }}
                                    </span>
                                </td>
                                <td>
                                    {{ date('d-m-Y, h:m a', strtotime($order->created_at)) }}
                                </td>
                                <td>
                                    <a href="{{ route('orders.edit', $order->id) }}"
                                       class="btn btn-outline-primary btn-sm btn-rounded">
                                        @lang('panel.edit')
                                    </a>
                                    <form action="{{ route('toggle_view', ['table' => 'order','id' => $order->id]) }}" method="post"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit"
                                                class="{{ $order->viewed ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                            {{ $order->viewed ? __('panel.cancel') : __('panel.done') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="post"
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
