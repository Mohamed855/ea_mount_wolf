@extends('layouts.panel')

@section('title', 'Add Admin')

@section('panel_content')
    <div class="container px-4">
        @if(session()->has('success'))
            <div class="alert alert-success text-center m-auto mb-2 col-12 col-lg-8" role="alert">
                {{ session('success') }}
            </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger text-center m-auto mb-2 col-12 col-lg-8" role="alert">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row text-center">
                    <div class="col-12 col-lg-8 m-auto">
                        <div class="overflow-scroll border bg-white shadow rounded-2 py-5 px-4 px-lg-5">
                            <h3 class="pb-4">Add New Admin</h3>
                            <div class="m-auto">
                                <form action="{{ route('admins.store') }}" method="POST">
                                    @csrf
                                    <div class="col-md-10 col-12 m-auto row">
                                        <div class="col-12 pb-2 px-1">
                                            <input type="text" name="name" class="form-control py-2" value="{{ old('name') }}" placeholder="Name">
                                        </div>
                                        <div class="col-12 pb-2 px-1">
                                            <input type="text" name="email" class="form-control py-2" value="{{ old('email') }}" placeholder="Email">
                                        </div>
                                        <div class="col-12 pb-2 px-1">
                                            <input type="text" name="password" class="form-control py-2" value="{{ old('password') }}" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-12 m-auto">
                                        <button type="submit" class="btn submit_btn p-2 my-3 w-100">Add Admin</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
