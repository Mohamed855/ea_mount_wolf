@extends('layouts.panel')

@section('title', 'Viewed Details')

@section('panel_title')
    Views Details
    <a href="{{ route('report.download', ['id' => $video_id, 'table' => 'video_views']) }}" class="btn btn-outline-success mx-3">Download Report</a>
@endsection

@section('panel_content')

    @include('includes.admin.panel_filter')
    <div class="scroll-bar overflow-scroll">
        <table class="table bg-white">
            <thead class="bg-light">
            <tr>
                <th>Full Name</th>
                <th>Username</th>
                <th>Role</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
                @if(count($video_user_views->get()) > 0)
                    @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                        @php($video_user_views = $video_user_views->whereDate('video_views.created_at', $_GET['date']))
                    @endif
                    @if(isset($_GET['search']))
                        @php($video_user_views = $video_user_views->where('users.first_name', 'like', '%' . $_GET['search'] . '%')->get())
                    @else
                        @php($video_user_views = $video_user_views->get())
                    @endif
                    @if(count($video_user_views) > 0)
                        @foreach($video_user_views as $user)
                            <tr>
                                <td>{{ $user->role == 1 ? ucfirst($user->first_name) : ucfirst($user->first_name) . ' ' . ucfirst($user->middle_name) . ' ' . ucfirst($user->last_name) }}</td>
                                <td>{{ $user->role == 1 ? '_____' : ucfirst($user->user_name) }}</td>
                                <td>
                                    @if($user->role == 1)
                                        Admin
                                    @elseif($user->role == 2)
                                        Manager
                                    @else
                                        Employee
                                    @endif
                                </td>
                                <td>{{ $user->created_at }}</td>
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
