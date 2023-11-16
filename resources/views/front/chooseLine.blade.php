@extends('layouts.app')

@section('title', 'Employee Access - Lines')

@section('content')

    @include('includes.front.navbar')

    <div class="content-wraper withnav">
        <div class="body-content">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="brain-box-title pb-5 mb-5">
                            <h2 class="d-inline">
                                {{ $current_sector->name }} Lines
                            </h2>
                        </div>
                        <div class="row buttons justify-content-evenly m-auto">
                            @foreach($selected_sector_lines as $line)
                                <a href="{{ route('drive', ['sector_id' =>  $current_sector->id, 'line_id' => $line->line_id]) }}"
                                   class="py-5 px-4 mb-5 control-btn text-decoration-none rounded"
                                   style="max-width: 200px;">
                                    <span class="rounded text-center text-white fs-5">{{ $line->name }}</span>
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.front.footer')
    </div>

    @include('includes.front.scripts')

@endsection
