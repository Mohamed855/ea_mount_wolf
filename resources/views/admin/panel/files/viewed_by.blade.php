@extends('layouts.panel')

@section('title', 'Views Details')

@section('panel_title')
    Views Details
    <a href="{{ route('report.download', ['id' => $file_id, 'table' => '']) }}" class="btn btn-outline-success mx-3">Download Report</a>
@endsection

@section('panel_content')

    <div class="scroll-bar overflow-scroll">
        <table class="table bg-white">
            <thead class="bg-light">
            <tr>
                <th>Full Name</th>
                <th>Username</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
                @if(count($file_user_views) > 0)
                    @foreach($file_user_views as $user)
                        <tr>
                            <td>{{ $user->role == 1 ? ucfirst($user->first_name) : ucfirst($user->first_name) . ' ' . ucfirst($user->middle_name) . ' ' . ucfirst($user->last_name) }}</td>
                            <td>{{ $user->role == 1 ? '_____' : ucfirst($user->user_name) }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">No one view this file yet</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection
