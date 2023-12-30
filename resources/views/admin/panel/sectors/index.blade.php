@extends('layouts.panel')

@section('title', 'Sectors Details')

@section('panel_title')
    Sectors Details
    <a href="{{ route('sectors.create') }}" class="btn btn-outline-success mx-3">Add New</a>
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
                    <th>Name</th>
                    <th>Lines</th>
                    <th>No. Files</th>
                    <th>No. Videos</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(count($sectors->get()) > 0)
                    @if(isset($_GET['search']))
                        @php($sectors = $sectors->where('sectors.name', 'like', '%' . $_GET['search'] . '%'))
                    @endif
                    @if(isset($_GET['from']) && DateTime::createFromFormat('Y-m-d', $_GET['from']))
                        @php($sectors = $sectors->whereDate('sectors.created_at', '>=' , $_GET['from']))
                    @endif
                    @if(isset($_GET['to']) && DateTime::createFromFormat('Y-m-d', $_GET['to']))
                        @php($sectors = $sectors->whereDate('sectors.created_at', '<=' , $_GET['to']))
                    @endif
                    @php($sectors = $sectors->get())
                    @if(count($sectors) > 0)
                        @foreach($sectors as $sector)
                            <tr>
                                <td>{{ $sector->name }}</td>
                                <td>
                                    @if(count($sector->line) > 0)
                                        <div style="max-height:100px; min-width: 100px; overflow-y:auto;">
                                            @for($i = 0; $i < count($sector->line); $i++)
                                                {{ $i + 1 }} - {{ $sector->line[$i]->name }}
                                                <br>
                                            @endfor
                                        </div>
                                    @else
                                        No Lines
                                    @endif
                                </td>
                                <td>{{ $countOfFiles->where('sector_id', '=', $sector->id)->count() }}</td>
                                <td>{{ $countOfVideos->where('sector_id', '=', $sector->id)->count() }}</td>
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
                        @include('includes.admin.empty_message')
                    @endif
                @else
                    @include('includes.admin.empty_message')
                @endif
            </tbody>
        </table>
    </div>
@endsection
