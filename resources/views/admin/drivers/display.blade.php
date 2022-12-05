@extends("admin.app") @section("content")
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body">
            
                @include('admin.drivers.display_tabs.driver_info')

                @include('admin.drivers.display_tabs.vehicle_info')

                @include('admin.drivers.display_tabs.license_info')

                @include('admin.drivers.display_tabs.add_type_of_use')

        </div>
    </div>
</div>
@endsection
