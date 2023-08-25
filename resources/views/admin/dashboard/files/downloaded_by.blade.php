@extends('layouts.app')

@section('title', 'Downloads Details')

@section('content')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 pb-5">
                        <p class="d-inline fs-4">
                            Downloads Details
                        </p>
                    </div>
                    <div class="col-lg-12">
                        <table class="table mb-5 bg-white">
                            <thead class="bg-light">
                            <tr>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($file_user_downloads) > 0)
                                @foreach($file_user_downloads as $user)
                                    <tr>
                                        <td>{{ $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name }}</td>
                                        <td>{{ $user->user_name }}</td>
                                        <td>{{ $user->created_at }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3">No one download this file yet</td>
                                </tr>
                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
