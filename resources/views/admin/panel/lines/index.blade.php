@extends('layouts.panel')

@section('title', 'Lines Details')

@section('panel_title')
    Lines Details
    <a href="{{ route('lines.create') }}" class="btn btn-outline-success mx-3">Add New</a>
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
                <th>Sectors</th>
                <th>No. Files</th>
                <th>No. Videos</th>
                <th>Status</th>
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
                @if(count($lines) > 0)
                    @foreach($lines as $line)
                    <tr>
                        <td>{{ $line->name }}</td>
                        <td>
                            @if(count($line->sector) > 0)
                                <div class="text-start" style="max-height:100px; overflow-y:auto;">
                                    @for($i = 0; $i < count($line->sector); $i++)
                                        {{ $i + 1 }} - {{ $line->sector[$i]->name }}
                                        <br>
                                    @endfor
                                </div>
                            @else
                                No sectors
                            @endif
                        </td>
                        <td>{{ \app\Models\FileLine::query()->whereJsonContains('lines', $line->id)->count() }}</td>
                        <td>{{ \app\Models\VideoLine::query()->whereJsonContains('lines', $line->id)->count() }}</td>
                        <td>
                            <span
                                class="{{ $line->status ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                {{ $line->status ? 'Published' : 'Suppressed' }}
                            </span>
                        </td>
                        <td>{{ date('d-m-Y, h:m a', strtotime($line->created_at)) }}</td>
                        <td>
                            <a href="{{ route('lines.edit', $line->id) }}"
                               class="btn btn-outline-primary btn-sm btn-rounded">
                                Edit
                            </a>
                            <form action="{{ route('toggle_publish_line', $line->id) }}"
                                  method="post" class="d-inline">
                                @csrf
                                <button type="submit"
                                        class="{{ $line->status ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                    {{ $line->status ? 'Suppress' : 'Publish' }}
                                </button>
                            </form>
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
                    @include('includes.admin.empty_message')
                @endif
            @else
                @include('includes.admin.empty_message')
            @endif
            </tbody>
        </table>
    </div>
@endsection
