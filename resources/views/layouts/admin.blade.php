<!doctype html>

<html lang="ar" dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('assets/include/css/fontawesome.css') }}">

        <!--logo-->
        <link rel="icon" type="image/icon" href="{{ asset('assets/images/logo.png') }}">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/bootstrap.min.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/css/call-styles.css') }}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">

        <!-- Scripts -->
        <script type="text/javascript" src="{{ asset('assets/include/js/virtual-select.min.js') }}"></script>
    </head>

    <body style="overflow: hidden;">
        @yield('content')
    </body>

</html>
