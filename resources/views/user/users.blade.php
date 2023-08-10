@extends('layouts.app')

@section('title', 'Users Details')

@section('content')
    @include('sections.nav')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <h3 class="text-center pb-5">Users Details</h3>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Joining Date</th>
                                <th scope="col">Title</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name }}</th>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ date('d-m-Y, h:m a', strtotime($user->created_at)) }}</td>
                                    <td>{{ $user->title }}</td>
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
