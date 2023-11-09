@extends('layouts.panel')

@section('title', 'Viewed Details')

@section('panel_title')
    Views Details
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
                @if(count($video_user_views) > 0)
                    @foreach($video_user_views as $user)
                        <tr>
                            <td>{{ $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name }}</td>
                            <td>{{ ucfirst($user->user_name) }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3">No one viewed this video yet</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection