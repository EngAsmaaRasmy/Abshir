@extends("admin.app")
@section("content")

    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">

                <div class="card form-card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">طلب جديد</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include("alert.success")
                            @include("alert.error")
                            <form class="form" method="post" action=""
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-info"></i> تفاصيل الطلب</h4>
                                    <div class="row" id="order-details">
                                        <div id="details-keys">
                                            <h6>اسم العميل</h6>
                                            <h6>رقم العميل</h6>
                                            <h6>العنوان</h6>
                                            <h6 style="">رقم الطلب</h6>
                                            <h6>تاريخ الطلب</h6>
                                            <h6>تفاصيل الطلب</h6>
                                            <h6>الصورة</h6>


                                        </div>
                                        <div id="details-values" style="margin-right: 3em">
                                            @if ($order->customer)
                                            <h6>{{$order->customer->name}}</h6>
                                            <h6>{{$order->customer->phone}}</h6>
                                            <h6>{{$order->customer_address}}</h6>  
                                            @else
                                            <h6>{{$order->customer_name}}</h6>
                                            <h6>{{$order->customer_phone}}</h6>
                                            <h6>{{$order->customer_address}}</h6>   
                                            @endif
                                            
                                            <h6>{{$order->id}}</h6>
                                            <h6>{{$order->created_at}}</h6>
                                            <h6>{{$order->details??"-"}}</h6>
                                            <h6>
                                            @if(! is_null($order->image))
                                                <a target="_blank" href="{{url($order->image)}}" >{{url($order->image)}}</a>
                                            @endif
                                            </h6>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
