<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm col-12" style="direction:rtl">
    <div class="container">
        @php($currAdmin = \Illuminate\Support\Facades\Auth::user())
        <div class="d-flex align-items-center fw-bold">
            <img src="{{
                $currAdmin->profile_image == null ?
                asset('assets/images/defaults/profile_image.jpg') :
                asset($currAdmin->profile_image)
            }}" style="width: 45px; height: 45px" class="rounded-circle"/>
            <p class="px-1" ></p>
            {{ ucfirst($currAdmin->name) }}
        </div>
    </div>
</nav>
