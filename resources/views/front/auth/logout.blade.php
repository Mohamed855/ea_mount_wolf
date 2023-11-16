@extends('layouts.admin')

@section('title', 'logout')

@section('content')
    <div class="content-wraper">
        <div class="body-content">
            <div class="container mt-4 mt-md-0">
                <div class="d-flex align-items-center justify-content-center" style="height: 100vh">
                    <div class="col-12 col-md-8 col-lg-6">
                        <div class="border bg-white shadow rounded-2 py-5 px-4 px-lg-5">
                            <h5 class="pb-3">Are you sure, you want to logout</h5>
                            <form action="{{ route('session.end') }}" method="post">
                                @csrf
                                <div class="my-4 text-end d-flex justify-content-between">
                                    <button class="btn d-inline-block p-2 col-5" onclick="history.back()">Back</button>
                                    <button type="submit" class="btn confirm_logout p-2 col-6">Confirm</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
