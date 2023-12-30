@extends('layouts.panel')

@section('title', 'Admins Details')

@section('panel_title')
    Admins Details
    @if(auth()->id() == 1) <a href="{{ route('admins.create') }}" class="btn btn-outline-success mx-3">Add New</a> @endif
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
    @include('includes.admin.users_filter')
    <div class="scroll-bar overflow-scroll">
        <table class="table bg-white">
            <thead class="bg-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Added At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(count($admins->get()) > 0)
                @if(isset($_GET['search']))
                    @php($admins = $admins->where('users.first_name', 'like', '%' . $_GET['search'] . '%')
                        ->orWhere('users.middle_name', 'like', '%' . $_GET['search'] . '%')
                        ->orWhere('users.last_name', 'like', '%' . $_GET['search'] . '%')
                        ->orWhere('users.email', $_GET['search'])
                        ->get()
                    )
                @else
                    @php($admins = $admins->get())
                @endif
                @if(count($admins) > 0)
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
                                    <div class="ms-3 pt-2">
                                        <p class="fw-bold mb-1 text-start">{{ ucfirst($admin->first_name) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                {{ $admin->email }}
                            </td>
                            <td>
                                <span
                                    class="{{ $admin->activated ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                    {{ $admin->activated ? 'Activated' : 'Waiting' }}
                                </span>
                            </td>
                            <td>{{ date('d-m-Y, h:m a', strtotime($admin->created_at)) }}</td>
                            <td>
                                @if($admin->id == auth()->id() || auth()->id() == 1)
                                    <a href="{{ route('admins.edit', $admin->id) }}"
                                       class="btn btn-outline-primary btn-sm btn-rounded">
                                        Edit
                                    </a>
                                @endif
                                @if($admin->id != 1 && auth()->id() == 1)
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
                                @endif
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
