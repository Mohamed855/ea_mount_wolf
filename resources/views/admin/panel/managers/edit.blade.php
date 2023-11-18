@extends('layouts.panel')

@section('title', 'Edit ' . ucfirst($selected_manager->user_name))

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
                            <h3 class="pb-4">{{ 'Edit ' . ucfirst($selected_manager->user_name) }}</h3>
                            <div class="m-auto">
                                <form action="{{ route('managers.update', $selected_manager->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-10 col-12 m-auto row">
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="first_name" class="form-control py-2" value="{{ $selected_manager->first_name }}" placeholder="First Name">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="middle_name" class="form-control py-2" value="{{ $selected_manager->middle_name }}" placeholder="Middle Name">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="last_name" class="form-control py-2" value="{{ $selected_manager->last_name }}" placeholder="Last Name">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="user_name" class="form-control py-2" value="{{ $selected_manager->user_name }}" placeholder="User Name">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="email" class="form-control py-2" value="{{ $selected_manager->email }}" placeholder="Email">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="crm_code" class="form-control py-2" value="{{ $selected_manager->crm_code }}" placeholder="CRM Code">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <input type="text" name="phone_number" class="form-control py-2" value="{{ $selected_manager->phone_number }}" placeholder="Phone Number">
                                        </div>
                                        <div class="col-12 col-md-6 pb-2 px-1">
                                            <select name="title" class="form-control py-2">
                                                <option value="0" disabled selected>Title *</option>
                                                @foreach($titles as $title)
                                                    <option value="{{ $title->id }}" {{ $title->id == $selected_manager->title_id ? 'selected' : '' }}>{{ $title->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 p-3 mt-2 mb-3 border rounded">
                                            <div class="row">
                                                <h6 class="text-start">Choose sectors</h6>
                                                @foreach($sectors as $sector)
                                                    <div class="col-12 col-md-6 col-xxl-4 text-start">
                                                        <input type="checkbox" id="{{ 's_' . $sector->id }}" name="{{ 's_' . $sector->id }}" value="{{ $sector->id }}" {{ in_array($sector->id, $integerSectorIds) ? 'checked' : '' }} style="cursor:pointer" onchange="generateSectorLines({{ $sector->id }})">
                                                        <label class="small" for="{{ 's_' . $sector->id }}">{{ $sector->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-12 p-3 border rounded">
                                            <h6 class="text-start">Choose lines</h6>
                                            @foreach($sectors as $sl)
                                                <div id="{{ 'sl_' . $sl->id }}" style="display: {{ in_array($sl->id, $integerSectorIds) ? 'flex' : 'none' }}">
                                                    @php($lines = \Illuminate\Support\Facades\DB::table('lines as l')
                                                            ->join('line_sector as ls', 'ls.line_id', '=', 'l.id')
                                                            ->where('ls.sector_id', $sl->id)
                                                            ->where('l.status', 1)
                                                            ->select(['l.id', 'l.name'])
                                                            ->orderBy('l.id')->get()
                                                        )
                                                    <div class="col-12 p-3 mt-2 mb-3 border rounded">
                                                        <div class="row">
                                                            <h6 class="text-start">{{ $sl->name }}</h6>
                                                            @foreach($lines as $line)
                                                                <div class="col-12 col-md-6 col-xxl-4 text-start">
                                                                    <input type="checkbox" name="{{ 's_' . $sl->id . 'l_' . $line->id }}" value="{{ $line->id }}" {{ in_array($line->id, $integerLineIds) ? 'checked' : '' }} style="cursor:pointer">
                                                                    <label class="small" for="{{ 's_' . $sl->id . 'l_' . $line->id }}">{{ $line->name }}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-10 col-12 m-auto">
                                        <button type="submit" class="btn submit_btn p-2 my-3 w-100">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.admin.scripts')
@endsection
