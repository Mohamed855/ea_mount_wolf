@extends('layouts.app')

@section('title', 'Users Details')

@section('content')
    @include('sections.nav')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 pb-5">
                        <p class="d-inline fs-4">
                            Users Details
                            <a href="{{ route('users.create') }}" class="btn btn-success mx-3">Add New</a>
                        </p>
                    </div>
                    <div class="col-lg-12">
                        <table class="table mb-0 bg-white">
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

                            @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex ps-5">
                                            <img src="{{
                                                        $user->profile_image == null ?
                                                        asset('images/profile_images/default_profile_image.jpg') :
                                                        asset('images/profile_images/' . $user->profile_image)
                                                     }}"
                                                alt=""
                                                style="width: 45px; height: 45px"
                                                class="rounded-circle"/>
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">{{ $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name }}</p>
                                                <p class="text-muted mb-0">{{ $user->user_name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span>{{ $user->sector_name . " | " }}</span>
                                        <span>{{ $user->line_name }}</span>
                                    </td>
                                    <td>{{ $user->title_name }}</td>
                                    <td>
                                        <span class="{{ $user->activated ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                            {{ $user->activated ? 'Activated' : 'Waiting' }}
                                        </span>
                                    </td>
                                    <td>{{ date('d-m-Y, h:m a', strtotime($user->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-primary btn-sm btn-rounded">
                                            Edit
                                        </a>
                                        <form action="{{ route('toggle_active', $user->id) }}" method="post" class="d-inline">
                                            @csrf
                                            <button type="submit" class="{{ $user->activated ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                                {{ $user->activated ? 'Deactive' : 'Active' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="post" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm btn-rounded">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
