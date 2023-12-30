@extends('layouts.panel')

@section('title', 'Announcement Details')

@section('panel_title')
    Title Details
    <a href="{{ route('titles.create') }}" class="btn btn-outline-success mx-3">Add New</a>
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
                    <th>Uploaded at</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @if(count($titles->get()) > 0)
                @if(isset($_GET['search']))
                    @php($titles = $titles->where('name', 'like', '%' . $_GET['search'] . '%'))
                @endif
                @if(isset($_GET['from']) && DateTime::createFromFormat('Y-m-d', $_GET['from']))
                    @php($titles = $titles->whereDate('created_at', '>=' , $_GET['from']))
                @endif
                @if(isset($_GET['to']) && DateTime::createFromFormat('Y-m-d', $_GET['to']))
                    @php($titles = $titles->whereDate('created_at', '<=' , $_GET['to']))
                @endif
                @php($titles = $titles->get())
                @if(count($titles) > 0)
                    @foreach($titles as $title)
                        <tr>
                            <td>{{ $title->name }}</td>
                            <td>{{ date('d-m-Y, h:m a', strtotime($title->created_at)) }}</td>
                            <td>
                                <form action="{{ route('titles.destroy', $title->id) }}"
                                      method="post" class="d-inline">
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
