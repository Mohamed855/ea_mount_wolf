@extends('layouts.dashboard')

@section('title', 'Sectors Details')

@section('dashboard_title')
    Sectors Details
    <a href="{{ route('sectors.create') }}" class="btn btn-outline-success mx-3">Add New</a>
@endsection

@section('dashboard_content')
    @include('sections.dashboard_filter')
    <div class="scroll-bar">
        <table class="table bg-white">
            <thead class="bg-light">
            <tr>
                <th>Name</th>
                <th>Lines</th>
                <th>No. Employees</th>
                <th>No. Files</th>
                <th>No. Views</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(count($sectors->get()) > 0)
                @if(isset($_GET['search']))
                    @php($sectors = $sectors->where('sectors.name', 'like', '%' . $_GET['search'] . '%'))
                @endif
                @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                    @php($sectors = $sectors->whereDate('sectors.created_at', $_GET['date'])->get())
                @else
                    @php($sectors = $sectors->get())
                @endif
                @foreach($sectors as $sector)
                    <tr>
                        <td>{{ $sector->name }}</td>
                        <td style="max-width: 150px">
                            <div class="ms-3">
                                <p class="fw-bold mb-0 text-center">
                                    {{ $sector_lines->where('sector_id', '=', $sector->id)->count() }}
                                </p>
                                <span class="text-muted mb-0">
                                                    @foreach($sector_lines->where('sector_id', '=', $sector->id) as $line)
                                        {{ $line->name }} |
                                    @endforeach
                                                </span>
                            </div>
                        </td>
                        <td>{{ $countOfEmployees->where('sector_id', '=', $sector->id)->count() }}</td>
                        <td>{{ $countOfFiles->where('sector_id', '=', $sector->id)->count() }}</td>
                        <td>{{ $countOfFiles->where('sector_id', '=', $sector->id)->sum('viewed') }}</td>
                        <td>{{ date('d-m-Y, h:m a', strtotime($sector->created_at)) }}</td>
                        <td>
                            <a href="{{ route('sectors.edit', $sector->id) }}"
                               class="btn btn-outline-primary btn-sm btn-rounded">
                                Edit
                            </a>
                            <form action="{{ route('sectors.destroy', $sector->id) }}" method="post"
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
                    <td colspan="7">There is no Sectors</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection