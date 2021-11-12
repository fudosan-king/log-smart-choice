<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html class="no-js">

<head>
  <script src="//statics.a8.net/a8sales/a8sales.js"></script>
  <script src="https://r.moshimo.com/af/r/maftag.js"></script>
  <script type="text/javascript" src="//aff.i-mobile.co.jp/script/lpcvlink.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0,user-scalable=0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  @if (preg_match('/(contact\/thanks)/', url()->current()))
  @php
    $customerId = isset($_COOKIE['orderrenoveCustomerId']) ? $_COOKIE['orderrenoveCustomerId'] : '';
  @endphp
  <script>
  var a8_affiliate_id = '{{ $customerId }}';
  var tamaru_id = '{{ $customerId }}';
  var imaf_uid = '{{ $customerId }}';
  var msmaf_m_v = '{{ $customerId }}';
  window.dataLayer = window.dataLayer || []; dataLayer.push ({ 'a8_affiliate_id': '{{ $customerId }}'});
  window.dataLayer = window.dataLayer || []; dataLayer.push ({ 'msmaf_m_v': '{{ $customerId }}'});
  window.dataLayer = window.dataLayer || []; dataLayer.push ({ 'tamaru_id': '{{ $customerId }}'});
  window.dataLayer = window.dataLayer || []; dataLayer.push ({ 'imaf_uid': '{{ $customerId }}'});
  window.dataLayer = window.dataLayer || []; dataLayer.push ({ 'orderrenove_customer_id': '{{ $customerId }}'});
  window.dataLayer = window.dataLayer || []; dataLayer.push ({ 'salesOrder': '{{ $customerId }}'});
  </script>
  @php
    unset($_COOKIE['orderrenoveCustomerId']); 
    setcookie('orderrenoveCustomerId', '', time()-3600); 
  @endphp
  @endif
  <meta charset="UTF-8">
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-KK6FDLZ');</script>
  <!-- End Google Tag Manager -->

  <meta property="og:locale" content="ja_JP">
  <link rel="apple-touch-icon" sizes="152x152" href="/assets/favicon_package_v0.16/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon_package_v0.16/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon_package_v0.16/favicon-16x16.png">
  <!-- <link rel="manifest" href="/assets/favicon_package_v0.16/site.webmanifest"> -->
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <!-- <link rel="preconnect" href="https://fonts.gstatic.com"> -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
  
  <link rel="stylesheet" rel="preload" onload="this.rel='stylesheet'" as="style" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" rel="preload" onload="this.rel='stylesheet'" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" type="text/css">
  <link rel="stylesheet" rel="preload" onload="this.rel='stylesheet'" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.standalone.min.css" type="text/css">
  <link rel="stylesheet" rel="preload" onload="this.rel='stylesheet'" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" type="text/css">
  <link rel="stylesheet" rel="preload" onload="this.rel='stylesheet'" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css"/>
  <link rel="stylesheet" rel="preload" onload="this.rel='stylesheet'" as="style" href="/assets/css/flickity.min.css" type="text/css" >
  <link rel="stylesheet" rel="preload" onload="this.rel='stylesheet'" as="style" href="/assets/css/styles.min.css" type="text/css">
  <!-- <link rel="stylesheet" href="/assets/css/mobile.css" type="text/css"> -->
  <link rel="stylesheet" rel="preload" onload="this.rel='stylesheet'" href="/css/app.min.css" type="text/css">
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KK6FDLZ"
  height="0" width="0" loading="lazy" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <div id="app">
    <index>
    </index>
  </div>
  <script rel="preload" as="script" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script rel="preload" as="script" src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
  <script rel="preload" as="script" src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
  <script rel="preload" as="script" src="https://unpkg.com/flickity@2.2.2/dist/flickity.pkgd.min.js"></script>
  <script rel="preload" as="script" src="/assets/js/bsnav.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.ja.min.js"></script> -->
  <script rel="preload" as="script" src='https://www.google.com/recaptcha/api.js'></script>
  <script rel="preload" as="script" src="{{ mix('/js/frontend.js') }}"></script>
  <script rel="preload" as="script" src="{{ mix('/js/manifest.js') }}"></script>
  <script rel="preload" as="script" src="{{ mix('/js/vendor.js') }}"></script>
</body>

</html>