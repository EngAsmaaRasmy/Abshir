@extends("admin.app") @section("content")
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
    

                @include('admin.drivers.display_tabs.trip_info')
        </div>
    </div>
</div>
@endsection
