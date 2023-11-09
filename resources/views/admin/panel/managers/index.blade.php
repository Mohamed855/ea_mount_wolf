@extends('layouts.panel')

@section('title', 'Managers Details')

@section('panel_title')
    Managers Details
    <a href="{{ route('managers.create') }}" class="btn btn-outline-success mx-3">Add New</a>
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
            @if(count($managers->get()) > 0)
                @if(isset($_GET['search']))
                    @php($managers = $managers->where('managers.first_name', 'like', '%' . $_GET['search'] . '%')
                        ->orwhere('managers.middle_name', 'like', '%' . $_GET['search'] . '%')
                        ->orwhere('managers.last_name', 'like', '%' . $_GET['search'] . '%')
                        ->orwhere('managers.user_name', 'like', '%' . $_GET['search'] . '%')
                        )
                @endif
                @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                    @php($managers = $managers->whereDate('managers.created_at', $_GET['date'])->get())
                @else
                    @php($managers = $managers->get())
                @endif
                @foreach($managers as $manager)
                    <tr>
                        <td>
                            <div class="d-flex ps-5">
                                <img src="{{
                                            $manager->profile_image == null ?
                                            asset('images/profile_images/default_profile_image.jpg') :
                                            asset('images/profile_images/' . $manager->profile_image)
                                         }}"
                                     alt=""
                                     style="width: 45px; height: 45px"
                                     class="rounded-circle"/>
                                <div class="ms-3">
                                    <p class="fw-bold mb-1 text-start">{{ $manager->first_name . ' ' . $manager->middle_name . ' ' . $manager->last_name }}</p>
                                    <p class="text-muted mb-0">{{ ucfirst($manager->user_name) }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="ms-3">
                                <p class="fw-bold mb-1">{{ $manager->email }}</p>
                                <p class="text-muted mb-0">{{ $manager->phone_number }}</p>
                            </div>
                        </td>
                        <td>
                            <p class="fw-bold mb-1 text-center">{{ $manager->sector_name }}</p>
                            <p class="text-muted mb-0 text-center">{{ $manager->line_name }}</p>
                        </td>
                        <td>{{ $manager->title_name }}</td>
                        <td>
                                            <span
                                                class="{{ $manager->activated ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                                {{ $manager->activated ? 'Activated' : 'Waiting' }}
                                            </span>
                        </td>
                        <td>{{ date('d-m-Y, h:m a', strtotime($manager->created_at)) }}</td>
                        <td>
                            <a href="{{ route('managers.edit', $manager->id) }}"
                               class="btn btn-outline-primary btn-sm btn-rounded">
                                Edit
                            </a>
                            <form action="{{ route('toggle_active', $manager->id) }}" method="post"
                                  class="d-inline">
                                @csrf
                                <button type="submit"
                                        class="{{ $manager->activated ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                    {{ $manager->activated ? 'Deactive' : 'Active' }}
                                </button>
                            </form>
                            <form action="{{ route('managers.destroy', $manager->id) }}" method="post"
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