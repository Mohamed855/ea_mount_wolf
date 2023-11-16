<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm col-12" style="direction:rtl">
    <div class="container">
        <div class="row justify-content-between">
            @php($currAdmin = \Illuminate\Support\Facades\Auth::user())
            <div class="fw-bold col-6 pt-2">{{ ucfirst(auth()->user()->first_name) }}</div>
            <div class="profile-pic bg-styles"
                 style="background-image:url({{
            $currAdmin->profile_image == null ?
            asset('storage/images/profile_images/default_profile_image.jpg') :
            asset('storage/images/profile_images/'. $currAdmin->profile_image)
         }});">
            </div>
        </div>
    </div>
</nav>
