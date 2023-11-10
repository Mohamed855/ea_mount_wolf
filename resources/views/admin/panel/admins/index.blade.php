@extends('layouts.panel')

@section('title', 'Admins Details')

@section('panel_title')
    Admins Details
    <a href="{{ route('admins.create') }}" class="btn btn-outline-success mx-3">Add New</a>
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
                <th>Name | Username</th>
                <th>Email</th>
                <th>Sector | Line</th>
                <th>Title</th>
                <th>Status</th>
                <th>Joining Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(count($admins->get()) > 0)
                @if(isset($_GET['search']))
                    @php($admins = $admins->where('admins.first_name', 'like', '%' . $_GET['search'] . '%')
                        ->orwhere('admins.middle_name', 'like', '%' . $_GET['search'] . '%')
                        ->orwhere('admins.last_name', 'like', '%' . $_GET['search'] . '%')
                        ->orwhere('admins.user_name', 'like', '%' . $_GET['search'] . '%')
                        )
                @endif
                @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                    @php($admins = $admins->whereDate('admins.created_at', $_GET['date'])->get())
                @else
                    @php($admins = $admins->get())
                @endif
                @foreach($admins as $admin)
                    <tr>
                        <td>
                            <div class="d-flex ps-5">
                                <img src="{{
                                            $admin->profile_image == null ?
                                            asset('storage/images/profile_images/default_profile_image.jpg') :
                                            asset('storage/images/profile_images/' . $admin->profile_image)
                                         }}"
                                     alt=""
                                     style="width: 45px; height: 45px"
                                     class="rounded-circle"/>
                                <div class="ms-3">
                                    <p class="fw-bold mb-1 text-start">{{ $admin->first_name . ' ' . $admin->middle_name . ' ' . $admin->last_name }}</p>
                                    <p class="text-muted mb-0">{{ ucfirst($admin->user_name) }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="ms-3">
                                <p class="fw-bold mb-1">{{ $admin->email }}</p>
                                <p class="text-muted mb-0">{{ $admin->phone_number }}</p>
                            </div>
                        </td>
                        <td>
                            <p class="fw-bold mb-1 text-center">{{ $admin->sector_name }}</p>
                            <p class="text-muted mb-0 text-center">{{ $admin->line_name }}</p>
                        </td>
                        <td>{{ $admin->title_name }}</td>
                        <td>
                                            <span
                                                class="{{ $admin->activated ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                                {{ $admin->activated ? 'Activated' : 'Waiting' }}
                                            </span>
                        </td>
                        <td>{{ date('d-m-Y, h:m a', strtotime($admin->created_at)) }}</td>
                        <td>
                            <a href="{{ route('admins.edit', $admin->id) }}"
                               class="btn btn-outline-primary btn-sm btn-rounded">
                                Edit
                            </a>
                            <form action="{{ route('toggle_active', $admin->id) }}" method="post"
                                  class="d-inline">
                                @csrf
                                <button type="submit"
                                        class="{{ $admin->activated ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                    {{ $admin->activated ? 'Deactive' : 'Active' }}
                                </button>
                            </form>
                            <form action="{{ route('admins.destroy', $admin->id) }}" method="post"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm btn-rounded">
                                    Delete
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
