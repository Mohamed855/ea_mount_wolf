@extends('layouts.panel')

@section('title', __('panel.admins'))

@section('panel_title')
    @lang('panel.admins')
    <a href="{{ route('admins.create') }}" class="btn btn-outline-success mx-3">@lang('panel.addNew')</a>
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
                    <th>@lang('panel.image')</th>
                    <th>@lang('panel.name')</th>
                    <th>@lang('panel.email')</th>
                    <th>@lang('panel.latestUpdate')</th>
                    <th>@lang('panel.actions')</th>
                </tr>
            </thead>
            <tbody>
                @if(count($admins->get()) > 0)
                    @if(isset($_GET['search']))
                        @php($admins = $admins->where('admins.name', 'like', '%' . $_GET['search'] . '%')
                            ->orwhere('admins.email', 'like', '%' . $_GET['search'] . '%'))
                    @endif
                    @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                        @php($admins = $admins->whereDate('admins.created_at', $_GET['date'])
                            ->orwhereDate('admins.updated_at', $_GET['date'])->get())
                    @else
                        @php($admins = $admins->get())
                    @endif
                    @if(count($admins) > 0)
                        @foreach($admins as $admin)
                            <tr>
                                <td>
                                    <img src="{{
                                        $admin->profile_image == null ?
                                        public_path('assets/images/defaults/profile_image.jpg') :
                                        public_path($admin->profile_image)
                                    }}" style="width: 45px; height: 45px" class="rounded-circle"/>
                                </td>
                                <td>
                                    {{ $admin->name }}
                                </td>
                                <td>
                                    <p class="fw-bold mb-1">{{ $admin->email }}</p>
                                </td>
                                <td>{{ date('d-m-Y, h:m a', strtotime($admin->updated_at)) }}</td>
                                <td>
                                    <a href="{{ route('admins.edit', $admin->id) }}"
                                       class="btn btn-outline-primary btn-sm btn-rounded">
                                        @lang('panel.edit')
                                    </a>
                                    <form action="{{ route('admins.destroy', $admin->id) }}" method="post"
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
