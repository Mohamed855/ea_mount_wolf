@extends('layouts.dashboard')

@section('title', 'Users Details')

@section('dashboard_title')
    Users Details
    <a href="{{ route('users.create') }}" class="btn btn-outline-success mx-3">Add New</a>
@endsection

@section('dashboard_content')
    @include('sections.dashboard_filter')
    <div class="scroll-bar">
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
            @if(count($users->get()) > 0)
                @if(isset($_GET['search']))
                    @php($users = $users->where('users.first_name', 'like', '%' . $_GET['search'] . '%')
                        ->orwhere('users.middle_name', 'like', '%' . $_GET['search'] . '%')
                        ->orwhere('users.last_name', 'like', '%' . $_GET['search'] . '%')
                        ->orwhere('users.user_name', 'like', '%' . $_GET['search'] . '%')
                        )
                @endif
                @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                    @php($users = $users->whereDate('users.created_at', $_GET['date'])->get())
                @else
                    @php($users = $users->get())
                @endif
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
                                    <p class="fw-bold mb-1 text-start">{{ $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name }}</p>
                                    <p class="text-muted mb-0">{{ $user->user_name }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="ms-3">
                                <p class="fw-bold mb-1">{{ $user->email }}</p>
                                <p class="text-muted mb-0">{{ $user->phone_number }}</p>
                            </div>
                        </td>
                        <td>
                            <p class="fw-bold mb-1 text-center">{{ $user->sector_name }}</p>
                            <p class="text-muted mb-0 text-center">{{ $user->line_name }}</p>
                        </td>
                        <td>{{ $user->title_name }}</td>
                        <td>
                                            <span
                                                class="{{ $user->activated ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                                {{ $user->activated ? 'Activated' : 'Waiting' }}
                                            </span>
                        </td>
                        <td>{{ date('d-m-Y, h:m a', strtotime($user->created_at)) }}</td>
                        <td>
                            <a href="{{ route('users.edit', $user->id) }}"
                               class="btn btn-outline-primary btn-sm btn-rounded">
                                Edit
                            </a>
                            <form action="{{ route('toggle_active', $user->id) }}" method="post"
                                  class="d-inline">
                                @csrf
                                <button type="submit"
                                        class="{{ $user->activated ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                    {{ $user->activated ? 'Deactive' : 'Active' }}
                                </button>
                            </form>
                            <form action="{{ route('users.destroy', $user->id) }}" method="post"
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
                <tr>
                    <td colspan="7">There is no Topics</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
