@extends('layouts.app')

@section('title', 'Confirm')

@section('content')

    <div class="content-wraper">
      <div class="body-content">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
              <div class="welcome-box welcome2">
                <h4>Welcome to Averroes Ground Rules</h4>
                <p>May you please confirm the account from application</p>
                <hr>
                <p>If the data are correct please approve user </p>
                <div class="welcome-cta margin-top-30">
                  <a href="#" class="ea-btns btn-confirm">Approve</a>
                  <a href="#" class="ea-btns btn-danger">Decline</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        @include('sections.logoFooter')
    </div>

    @include('sections.scripts')

@endsection
