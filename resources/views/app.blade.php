<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <title>log Smart Choice</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- lib -->
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('/favicon_package_v0.16/apple-touch-icon.png') }}">
    <link href="/design/css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/favicon_package_v0.16/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/favicon_package_v0.16/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('/favicon_package_v0.16/site.webmanifest') }}">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/design/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/design/css/animate.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/design/css/flickity.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/design/css/bsnav.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/design/css/styles.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('/design/css/mobile.css') }}" type="text/css">

    <title>Laravel</title>

</head>

<body>
    <div id="app">
        <index>
        </index>
    </div>

    <script src="{{ asset('/js/frontend.js') }}"></script>
    <script src="/design/js/jquery.min.js"></script>
    <script src="/design/js/popper.min.js"></script>
    <script src="/design/js/bootstrap.min.js"></script>
    <script src="/design/js/flickity.pkgd.min.js"></script>
    <script src="/design/js/bsnav.min.js"></script>
    <script src="/design/js/functions.js"></script>
</body>

</html>