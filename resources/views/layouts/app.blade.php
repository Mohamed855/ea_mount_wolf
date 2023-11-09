<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="theme-color" content="#093248">
    <meta name="msapplication-navbutton-color" content="#093248">
    <meta name="apple-mobile-web-app-status-bar-style" content="#093248">

    <!-- Page title -->
    <title>@yield('title')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ public_path('assets/css/bootstrap/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ public_path('assets/css/call-styles.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ public_path('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ public_path('assets/css/animate.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ public_path('assets/js/wow.min.js') }}"></script>
    <script>new WOW().init();</script>
</head>

<body class="antialiased text-center">
    @yield('content')
</body>

</html>
