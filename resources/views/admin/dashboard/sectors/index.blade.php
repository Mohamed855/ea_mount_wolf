@extends('layouts.app')

@section('title', 'Sectors Details')

@section('content')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 pb-5">
                        <p class="d-inline fs-4">
                            Sectors Details
                            <a href="{{ route('sectors.create') }}" class="btn btn-outline-success mx-3">Add New</a>
                        </p>
                    </div>
                    <div class="col-lg-12">
                        <table class="table mb-5 bg-white">
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

                            @foreach($sectors as $sector)
                                <tr>
                                    <td>{{ $sector->name }}</td>
                                    <td style="max-width: 150px">
                                        <div class="ms-3">
                                            <p class="fw-bold mb-0 text-center">
                                                {{ $lines->where('sector_id', '=', $sector->id)->count() }}
                                            </p>
                                            <span class="text-muted mb-0">
                                                @foreach($lines->where('sector_id', '=', $sector->id) as $line)
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
                                        <a href="{{ route('sectors.edit', $sector->id) }}" class="btn btn-outline-primary btn-sm btn-rounded">
                                            Edit
                                        </a>
                                        <form action="{{ route('sectors.destroy', $sector->id) }}" method="post" class="d-inline">
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
