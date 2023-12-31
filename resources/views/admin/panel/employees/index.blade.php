@extends('layouts.panel')

@section('title', 'Employees Details')

@section('panel_title')
    Employees Details
    <a href="{{ route('employees.create') }}" class="btn btn-outline-success mx-3">Add New</a>
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
                <th>Name | Username</th>
                <th>Email</th>
                <th>Title</th>
                <th>Sectors</th>
                <th>Lines</th>
                <th>Status</th>
                <th>Added At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(count($employees->get()) > 0)
                @if(isset($_GET['search']))
                    @php($employees = $employees->where('first_name', 'like', '%' . $_GET['search'] . '%')
                        ->orWhere('users.middle_name', 'like', '%' . $_GET['search'] . '%')
                        ->orWhere('users.last_name', 'like', '%' . $_GET['search'] . '%')
                        ->orWhere('users.email', $_GET['search'])
                        ->orWhere('users.crm_code', $_GET['search'])
                        ->get()
                    )
                @else
                    @php($employees = $employees->get())
                @endif
                @if(count($employees) > 0)
                    @foreach($employees as $employee)
                        <tr>
                            <td>
                                <div class="d-flex ps-5">
                                    <img src="{{
                                                $employee->profile_image == null ?
                                                asset('storage/images/profile_images/default_profile_image.jpg') :
                                                asset('storage/images/profile_images/' . $employee->profile_image)
                                             }}"
                                         alt=""
                                         style="width: 45px; height: 45px"
                                         class="rounded-circle"/>
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1 text-start">{{ $employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name }}</p>
                                        <p class="text-muted mb-0">{{ ucfirst($employee->user_name) }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="ms-3">
                                    <p class="fw-bold mb-1">{{ $employee->email }}</p>
                                    <p class="text-muted mb-0">{{ $employee->phone_number }}</p>
                                </div>
                            </td>
                            @php($title = \App\Models\Title::query()->select('name')->find($employee->title_id))
                            <td>{{ $title->name ?? 'Not defined' }}</td>
                            <td>
                                @php($employee_sectors = \App\Models\Sector::query()->whereIn('id', $employee->sectors)->get())
                                @if(count($employee_sectors) > 0)
                                    <div class="text-start" style="max-height:100px; overflow-y:auto;">
                                        @for($i = 0; $i < count($employee_sectors); $i++)
                                            {{ $i + 1 }} - {{ $employee_sectors[$i]->name }}
                                            <br>
                                        @endfor
                                    </div>
                                @else
                                    No sectors
                                @endif
                            </td>
                            <td>
                                @php($employee_lines = \App\Models\Line::query()->whereIn('id', $employee->lines)->get())
                                @if(count($employee_lines) > 0)
                                    <div class="text-start" style="max-height:100px; overflow-y:auto;">
                                        @for($i = 0; $i < count($employee_lines); $i++)
                                            {{ $i + 1 }} - {{ $employee_lines[$i]->name }}
                                            <br>
                                        @endfor
                                    </div>
                                @else
                                    No Lines
                                @endif
                            </td>
                            <td>
                                                <span
                                                    class="{{ $employee->activated ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                                    {{ $employee->activated ? 'Activated' : 'Waiting' }}
                                                </span>
                            </td>
                            <td>{{ date('d-m-Y, h:m a', strtotime($employee->created_at)) }}</td>
                            <td>
                                <a href="{{ route('employees.edit', $employee->id) }}"
                                   class="btn btn-outline-primary btn-sm btn-rounded">
                                    Edit
                                </a>
                                <form action="{{ route('toggle_active', $employee->id) }}" method="post"
                                      class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="{{ $employee->activated ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                        {{ $employee->activated ? 'Deactive' : 'Active' }}
                                    </button>
                                </form>
                                <form action="{{ route('employees.destroy', $employee->id) }}" method="post"
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
            @else
                @include('includes.admin.empty_message')
            @endif
            </tbody>
        </table>
    </div>
@endsection
