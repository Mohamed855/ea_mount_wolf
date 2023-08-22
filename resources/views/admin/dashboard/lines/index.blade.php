@extends('layouts.app')

@section('title', 'Lines Details')

@section('content')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 pb-5">
                        <p class="d-inline fs-4">
                            Lines Details
                            <a href="{{ route('lines.create') }}" class="btn btn-outline-success mx-3">Add New</a>
                        </p>
                    </div>
                    <div class="col-lg-12">
                        <table class="table mb-5 bg-white">
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

                            @foreach($lines as $line)
                                <tr>
                                    <td>{{ $line->name }}</td>
                                    <td>{{ $countOfEmployees->where('line_id', '=', $line->id)->count() }}</td>
                                    <td>{{ $countOfFiles->where('line_id', '=', $line->id)->count() }}</td>
                                    <td>{{ $countOfFiles->where('line_id', '=', $line->id)->sum('viewed') }}</td>
                                    <td>{{ date('d-m-Y, h:m a', strtotime($line->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('lines.edit', $line->id) }}" class="btn btn-outline-primary btn-sm btn-rounded">
                                            Edit
                                        </a>
                                        <form action="{{ route('lines.destroy', $line->id) }}" method="post" class="d-inline">
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
