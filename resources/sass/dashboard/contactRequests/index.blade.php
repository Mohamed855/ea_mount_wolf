@extends('layouts.panel')

@section('title', __('panel.contactRequests'))

@section('panel_title')
    @lang('panel.contactRequests')
@endsection

@section('panel_content')
    @if(session()->has('success'))
        <div class="alert alert-success text-center" role="alert">
            {{ session('success') }}
        </div>
    @elseif(session()->has('error'))
        <div class="alert alert-danger text-center" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if(session('sendEmailTo'))
        <script>window.open("https://mail.google.com/mail/?view=cm&fs=1&to={{ session('sendEmailTo') }}", "_blank");</script>
    @endif

    @include('includes.admin.panel_filter')
    <div class="scroll-bar overflow-scroll">
        <table class="table bg-white">
            <thead class="bg-light">
                <tr>
                    <th>@lang('panel.name')</th>
                    <th>@lang('panel.email')</th>
                    <th>@lang('panel.message')</th>
                    <th>@lang('panel.status')</th>
                    <th>@lang('panel.requestedAt')</th>
                    <th>@lang('panel.actions')</th>
                </tr>
            </thead>
            <tbody>
                @if(count($contacts->get()) > 0)
                    @if(isset($_GET['search']))
                        @php($contacts = $contacts->where('contacts.name', 'like', '%' . $_GET['search'] . '%')
                            ->orwhere('contacts.email', 'like', '%' . $_GET['search'] . '%')
                            ->orwhere('contacts.message', 'like', '%' . $_GET['search'] . '%'))
                    @endif
                    @if(isset($_GET['date']) && DateTime::createFromFormat('Y-m-d', $_GET['date']))
                        @php($contacts = $contacts->whereDate('contacts.updated_at', $_GET['date'])
                            ->orwhereDate('contacts.updated_at', $_GET['date'])->get())
                    @else
                        @php($contacts = $contacts->get())
                    @endif
                    @if(count($contacts) > 0)
                        @foreach($contacts as $contact)
                            <tr>
                                <td>
                                    {{ $contact->name }}
                                </td>
                                <td>
                                    {{ $contact->email }}
                                </td>
                                <td>
                                    <p class="para text-center">
                                        {{ $contact->message }}
                                    </p>
                                </td>
                                <td>
                                    <span
                                        class="{{ $contact->viewed ? 'bg-success' : 'bg-secondary' }} p-2 text-white small rounded">
                                        {{ $contact->viewed ? __('panel.responded') : __('panel.waiting') }}
                                    </span>
                                </td>
                                <td>
                                    {{ date('d-m-Y, h:m a', strtotime($contact->created_at)) }}
                                </td>
                                <td>
                                    <form action="{{ route('toggle_view', ['table' => 'contact','id' => $contact->id]) }}" method="post"
                                          class="d-inline">
                                        @csrf
                                        @if(! $contact->viewed)
                                            <input name="email" type="hidden" value="{{ $contact->email }}">
                                        @endif
                                        <button type="submit"
                                                class="{{ $contact->viewed ? 'btn-outline-secondary' : 'btn-outline-success' }} btn btn-sm btn-rounded">
                                            {{ $contact->viewed ? __('panel.cancel') : __('panel.response') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('contact-requests.destroy', $contact->id) }}" method="post"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm btn-rounded">
                                            @lang('panel.delete')
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @include('includes.admin.empty_message')
                    @endif
                @else
                    @include('includes.admin.empty_message')
                @endif
            </tbody>
        </table>
    </div>
@endsection
