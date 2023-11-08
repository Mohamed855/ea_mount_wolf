@extends('layouts.panel')

@section('title', __('panel.panel') . ' - ' . __('panel.overview'))

@section('panel_title')
    @lang('panel.overview')
@endsection

@section('panel_content')
    <div class="body-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="row justify-content-around">
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded panel_info w-25">
                            <h3 class="rounded text-center fs-6">@lang('panel.admins')</h3>
                            <span class="rounded fs-5">{{ $adminCount }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded panel_info w-25">
                            <h3 class="rounded text-center fs-6">@lang('panel.sliders')</h3>
                            <span class="rounded fs-5">{{ $sliderCount }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded panel_info w-25">
                            <h3 class="rounded text-center fs-6">@lang('panel.clients')</h3>
                            <span class="rounded fs-5">{{ $clientCount }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded panel_info w-25">
                            <h3 class="rounded text-center fs-6">@lang('panel.categories')</h3>
                            <span class="rounded fs-5">{{ $categoryCount }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded panel_info w-25">
                            <h3 class="rounded text-center fs-6">@lang('panel.meals')</h3>
                            <span class="rounded fs-5">{{ $mealCount }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded panel_info w-25">
                            <h3 class="rounded text-center fs-6">@lang('panel.contactRequests')</h3>
                            <span class="rounded fs-5">{{ $contactCount }}</span>
                        </div>
                        <div class="py-4 px-5 mb-5 mx-3 text-center shadow rounded panel_info w-25">
                            <h3 class="rounded text-center fs-6">@lang('panel.orders')</h3>
                            <span class="rounded fs-5">{{ $orderCount }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
