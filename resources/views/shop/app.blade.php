<html class="loaded" lang="en" data-textdirection="rtl" style="font-family:'Almarai', sans-serif"><!-- BEGIN: Head-->
{{--@php($user=\Illuminate\Support\Facades\Auth::user())--}}

@include("shop.layout.head")


<body
    class="vertical-layout vertical-collapsed-menu 2-columns fixed-navbar pace-done menu-expanded vertical-menu-modern"
    data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
<div >
    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99"
             style="transform: translate3d(100%, 0px, 0px)">



            <div class="pace-progress-inner"></div>

            <div class="pace-activity"></div>

        </div>
    </div>

    <div id="app">
    @include("shop.layout.header")




    @include("shop.layout.sidebar")


              @yield("content")
          </div>

    @include("shop.layout.footer")

</div>

<script src="{{asset("app-assets/vendors/js/vendors.min.js")}}"></script>


<script src="{{asset("app-assets/js/vendors.min.js")}}"></script>

<script src="{{asset("app-assets/js/core/app-menu.js")}}"></script>
<script src="{{asset("app-assets/js/core/app.js")}}"></script>
<script src="{{asset("app-assets/js/jquery.min.js")}}"></script>
<script src="{{asset("app-assets/js/bootstrap.min.js")}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>



<script src="{{asset("app-assets/js/datatables.min.js")}}"></script>

<script src="{{asset("assets/js/custom-js.js")}}"></script>
<script src="{{asset("js/app.js")}}"></script>
</body>
</html>
