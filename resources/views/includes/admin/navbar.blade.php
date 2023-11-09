<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm col-12" style="direction:rtl">
    <div class="container">
        @php($currAdmin = \Illuminate\Support\Facades\Auth::user())
        <div class="profile-pic bg-styles"
             style="background-image:url({{
            $currAdmin->profile_image == null ?
            asset('images/profile_images/default_profile_image.jpg') :
            asset('images/profile_images/'. $currAdmin->profile_image)
         }});">
        </div>
    </div>
</nav>
