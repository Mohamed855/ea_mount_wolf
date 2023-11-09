@extends('layouts.app')

@section('title', 'Change Password')

@section('content')

    @include('includes.front.navbar')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="col-lg-7 m-auto">
                            <form action="{{ route('password.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="col-lg-8 m-auto">
                                    <div class="pb-2 px-1">
                                        <input type="password" name="old_password"
                                               class="form-control @error('old_password') is-invalid @enderror"
                                               placeholder="old password *">
                                        @error('old_password')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <input type="password" name="new_password"
                                               class="form-control @error('new_password') is-invalid @enderror"
                                               placeholder="new password *">
                                        @error('new_password')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="pb-2 px-1">
                                        <input type="password" name="confirm_new_password"
                                               class="form-control @error('confirm_new_password') is-invalid @enderror"
                                               placeholder="confirm password *">
                                        @error('confirm_new_password')
                                        <span class="text-danger" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    @if(session()->has('changedSuccessfully'))
                                        <div class="m-auto">
                                            <span class="text-primary"
                                                  role="alert">{{ session()->get('changedSuccessfully') }}</span>
                                        </div>
                                    @elseif(session()->has('incorrect'))
                                        <div class="m-auto">
                                            <span class="text-danger"
                                                  role="alert">{{ session()->get('incorrect') }}</span>
                                        </div>
                                    @endif

                                    <button type="submit" class="btn btn-outline-primary p-2 my-2 mx-lg-2">Update
                                        Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.front.footer')
    </div>

    @include('includes.front.scripts')

@endsection
