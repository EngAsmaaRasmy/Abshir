<html class="loaded" lang="en" data-textdirection="rtl" style="font-family: 'Noto Kufi Arabic', sans-serif;"><!-- BEGIN: Head-->


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>HMF - لوحة تحكم الادمن</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic&family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/vendors/css/vendors-rtl.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/vendors/css/datatables.min.css")}}">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> --}}


    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/css-rtl/bootstrap.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/css-rtl/bootstrap-extended.css")}}">


    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/css-rtl/colors.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/css-rtl/components.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/css-rtl/custom-rtl.css")}}">

    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/css-rtl/core/menu/menu-types/vertical-menu-modern.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/css-rtl/core/colors/palette-gradient.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("app-assets/css-rtl/pages/single-page.css")}}">


    <link rel="stylesheet" type="text/css" href="{{asset("assets/css/HomeStyle.css")}}">

</head>


<body
    class="vertical-layout vertical-collapsed-menu 2-columns fixed-navbar pace-done menu-expanded vertical-menu-modern"
    data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<div >
    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99"
             style="transform: translate3d(100%, 0px, 0px); font-family: Almarai,sans-serif">



            <div class="pace-progress-inner"></div>

            <div class="pace-activity"></div>

        </div>
    </div>

    <div id="app">
    @include("admin.layout.header")




    @include("admin.layout.sidebar")


              @yield("content")
          </div>

          @include("admin.layout.footer")
        </div>
    
    </div>
<script src="{{asset("app-assets/vendors/js/vendors.min.js")}}"></script>


<script src="{{asset("app-assets/js/vendors.min.js")}}"></script>

<script src="{{asset("app-assets/js/core/app-menu.js")}}"></script>
<script src="{{asset("app-assets/js/core/app.js")}}"></script>
<script src="{{asset("app-assets/js/jquery.min.js")}}"></script>
<script src="{{asset("app-assets/js/bootstrap.min.js")}}"></script>
<script src="{{asset("app-assets/js/jquery.repeater.js")}}"></script>



<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script src="{{asset("app-assets/js/datatables.min.js")}}"></script>

@yield('js')

<script type="module" src="{{asset("assets/js/custom-js.js")}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYWRfCUWOYMBlEDyM6dlXft2Fl4KIeWNk&libraries=places&language=ar&region=EG" async ></script>
<script src="{{asset("js/app.js")}}"></script>
    
</body>
</html
