<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html class="no-js">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="UTF-8">

@if ($tags)
@foreach($tags as $tag)
@if ($tag->type == 'meta')
  <{{ $tag->type }} {{ $tag->name }}="{{ $tag->name_content }}" content="{{ $tag->tag_content }}" />
@elseif ($tag->type == 'title')
  <title>{{ $tag->tag_content }}</title>
@endif
@endforeach
@endif

  <link rel="apple-touch-icon" sizes="152x152" href="/assets/favicon_package_v0.16/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon_package_v0.16/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon_package_v0.16/favicon-16x16.png">
  <!-- <link rel="manifest" href="/assets/favicon_package_v0.16/site.webmanifest"> -->
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/bootstrap-datepicker.min.css" type="text/css">
  <link rel="stylesheet" href="/assets/css/bootstrap-datepicker.standalone.min.css" type="text/css">
  <link rel="stylesheet" href="/assets/css/animate.min.css" type="text/css">
  <link rel="stylesheet" type="text/css" href="/assets/css/flickity.min.css">
  <link rel="stylesheet" type="text/css" href="/assets/css/bsnav.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
  <link rel="stylesheet" href="/assets/css/styles.css" type="text/css">
  <!-- <link rel="stylesheet" href="/assets/css/mobile.css" type="text/css"> -->
  <link rel="stylesheet" href="/css/app.css" type="text/css">
</head>

<body>
  <div id="app">
    <index>
    </index>
  </div>

  <script src="{{ asset('/js/frontend.js') }}"></script>
  <script src="{{ asset('/js/globalHelper.js') }}"></script>
  <script src="/assets/js/jquery.min.js"></script>
  <script src="/assets/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/flickity.pkgd.min.js"></script>
  <script src="/assets/js/bsnav.min.js"></script>
  <script src="/assets/js/functions.js"></script>
  <script src="/assets/js/bootstrap-datepicker.js"></script>
  <script src="/assets/js/bootstrap-datepicker.ja.min.js"></script>
  <!-- <script src="/assets/js/Chart.bundle.min.js"></script>
  <script src="/assets/js/chartjs-plugin-labels.js"></script> -->
  <script src="/assets/js/ion.rangeSlider.min.js"></script>
  <!-- <script src="/assets/js/chart_custom.js"></script> -->
</body>

</html>