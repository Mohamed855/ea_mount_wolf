@extends('layouts.app')

@section('title', 'Employee Access')

@section('content')

    @include('sections.nav')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="announcement-title">
                            <div class="announcement-logo"><img src="{{ asset('images/logo.png') }}" class="mw-100" alt=""></div>
                            <div class="announcement-title-txt">AVS Announcement</div>
                        </div>
                        <div class="date">
                            <form>
                                <div class="row form-group">
                                    <!-- <label for="date" class="col-sm-1 col-form-label">Date</label> -->
                                    <div class="col-sm-3">
                                        <div class="input-group date" id="datepicker">
                                            <input type="text" class="form-control">
                                            <span class="input-group-append">
                                                <span class="input-group-text bg-white d-block">
                                                    <i class="fa fa-calendar"></i>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="departments-section">
                            <div class="department-box active">
                                <div class="department-title">HR</div>
                                <div class="department-views">Views <i class="fa-solid fa-eye"></i> <span class="views-number">203K</span></div>
                            </div>
                            <div class="department-box">
                                <div class="department-title">Sales</div>
                                <div class="department-views">Views <i class="fa-solid fa-eye"></i> <span class="views-number">203K</span></div>
                            </div>
                            <div class="department-box">
                                <div class="department-title">Marketing</div>
                                <div class="department-views">Views <i class="fa-solid fa-eye"></i> <span class="views-number">203K</span></div>
                            </div>
                            <div class="department-box">
                                <div class="department-title">Compliance <br> and ROI</div>
                                <div class="department-views">Views <i class="fa-solid fa-eye"></i> <span class="views-number">203K</span></div>
                            </div>
                            <div class="department-box">
                                <div class="department-title">SFE</div>
                                <div class="department-views">Views <i class="fa-solid fa-eye"></i> <span class="views-number">203K</span></div>
                            </div>
                            <div class="department-box">
                                <div class="department-title">Training</div>
                                <div class="department-views">Views <i class="fa-solid fa-eye"></i> <span class="views-number">203K</span></div>
                            </div>
                            <div class="department-box">
                                <div class="department-title">Office</div>
                                <div class="department-views">Views <i class="fa-solid fa-eye"></i> <span class="views-number">203K</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('sections.footer')

    </div>

    @include('sections.scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $('#datepicker').datepicker();
        });
    </script>
@endsection
