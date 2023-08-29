@extends('layouts.dashboard')

@section('title', 'Lines Details')

@section('dashboard_title')
    Lines Details
    <a href="{{ route('lines.create') }}" class="btn btn-outline-success mx-3">Add New</a>
@endsection

@section('dashboard_content')
    @include('sections.dashboard_filter')
    <div class="scroll-bar">
        <table class="table bg-white">
            <thead class="bg-light">
            <tr>
                <th>Name</th>
                <th>No. Employees</th>
                <th>No. Files</th>
                <th>No. Views</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(count($lines->get()) > 0)
                @if(isset($_GET['search']))
                    @php($lines = $lines->where('lines.name', 'like', '%' . $_GET['search'] . '%'))
                @endif
                @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                    @php($lines = $lines->whereDate('lines.created_at', $_GET['date'])->get())
                @else
                    @php($lines = $lines->get())
                @endif
                @foreach($lines as $line)
                    <tr>
                        <td>{{ $line->name }}</td>
                        <td>{{ $countOfEmployees->where('line_id', '=', $line->id)->count() }}</td>
                        <td>{{ $countOfFiles->where('line_id', '=', $line->id)->count() }}</td>
                        <td>{{ $countOfFiles->where('line_id', '=', $line->id)->sum('viewed') }}</td>
                        <td>{{ date('d-m-Y, h:m a', strtotime($line->created_at)) }}</td>
                        <td>
                            <a href="{{ route('lines.edit', $line->id) }}"
                               class="btn btn-outline-primary btn-sm btn-rounded">
                                Edit
                            </a>
                            <form action="{{ route('lines.destroy', $line->id) }}" method="post"
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
                    <td colspan="6">There is no Lines</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
@endsection
