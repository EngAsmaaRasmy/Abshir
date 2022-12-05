@extends("shop.app")
@section("content")
    @php($driver=\App\Models\admin\DriverModel::where("shop",\Illuminate\Support\Facades\Auth::id())->get()->first())
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
                            <form class="form" method="post" action="{{route("shop.category.save")}}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-info"></i> تفاصيل الطلب</h4>
                                    <div class="row" id="order-details">
                                        <div id="details-keys">
                                            <h6>اسم العميل</h6>
                                            <h6 style="">رقم الطلب</h6>
                                            <h6>تاريخ الطلب</h6>
                                            <h6>تفاصيل اضافيه عن الطلب</h6>

                                            @if($driver&& $orderProducts->first()->orderRel->driver==$driver->id)
                                                <h6>العنوان</h6>
                                                <h6>رقم التليفون</h6>
                                                <h6>اجمالى السعر بالتوصيل</h6>

                                            @endif
                                        </div>
                                        <div id="details-values" style="margin-right: 3em">
                                            @if ($orderProducts->first()->type == "app")
                                            <h6>{{$orderProducts->first()->orderRel->customerRel->name}}</h6>
                                            <h6>{{$orderProducts->first()->orderRel->id}}</h6>
                                            <h6>{{$orderProducts->first()->orderRel->created_at->format("d-m-yy   h:i a")}}</h6>
                                            <h6>{{$orderProducts->first()->orderRel->order_description??"لا يوجد وصف"}}</h6>
                                            @if($driver&&$orderProducts->first()->orderRel->driver==$driver->id)
                                                <h6>{{json_decode($orderProducts->first()->orderRel->user_address)->address}}</h6>
                                                <h6>{{$orderProducts->first()->orderRel->customerRel->phone}}</h6>
                                                <h6>{{$orderProducts->first()->orderRel->must_paid_price}}</h6>


                                            @endif
                                            @else
                                            <h6>{{$orderProducts->first()->adminOrderRel->customer_name}}</h6>
                                            <h6>{{$orderProducts->first()->adminOrderRel->id}}</h6>
                                            <h6>{{$orderProducts->first()->adminOrderRel->created_at->format("d-m-yy   h:i a")}}</h6>
                                            <h6>{{$orderProducts->first()->adminOrderRel->details??"لا يوجد وصف"}}</h6>
                                            @if($driver&&$orderProducts->first()->adminOrderRel->driver==$driver->id)
                                                <h6>{{$orderProducts->first()->adminOrderRel->user_address}}</h6>
                                                <h6>{{$orderProducts->first()->adminOrderRel->customer_phone}}</h6>
                                                <h6>{{$orderProducts->first()->adminOrderRel->must_paid}}</h6>


                                            @endif
                                            @endif


                                        </div>
                                    </div>
                                    <h4 class="form-section"> المنتجات</h4>
                                    <div class="table-responsive-sm">
                                        <table class="table">
                                            <thead class="bg-primary white">
                                            <tr>
                                                <th>#</th>
                                                <th>المنتج</th>
                                                <th>الكمية</th>
                                                <th>السعر</th>
                                                <th>العرض</th>
                                                <th>قيمة العرض</th>
                                                <th>اجمالى السعر بعد الخصم</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @isset($orderProducts)
                                                @foreach($orderProducts as $product)
                                                    <tr id="product-info-row">
                                                        <th scope="row">{{$product->getRelationValue('productRel')->id}}</th>

                                                        <td>{{$product->getRelationValue("productRel")->name_ar}}</td>
                                                        <td>{{$product->amount}}</td>
                                                        <td>
                                                            {{$product->size->price}}
                                                        </td>
                                                        <td>@if($product->size->offer!=null){{$product->size->offer->name}}@endif</td>
                                                        @if($product->size->offer)
                                                            @switch($product->size->offer->type)
                                                                @case(1)
                                                                <td style="color: green">{{$product->size->offer->percentage }}
                                                                    %
                                                                </td>
                                                                @break
                                                                @case(2)
                                                                <td style="color: green">
                                                                    اشترى {{$product->size->offer->amount}} واحصل
                                                                    على {{$product->size->offer->gift_amount}}</td>
                                                                @break
                                                                @case(3)
                                                                <td style="color: green">{{$product->size->offer->value}}
                                                                    جنيه
                                                                </td>
                                                                @break


                                                            @endswitch
                                                        @else
                                                            <td></td>
                                                        @endif
                                                        @isset($product->size->offer)
                                                            @switch($product->size->offer->type)
                                                                @case(1)
                                                                <td>{{($product->size->price - ($product->size->price*($product->size->offer->percentage/100)))*$product->amount}}
                                                                    جنيه
                                                                </td>
                                                                @break
                                                                @case(3)
                                                                <td>{{($product->size->price-$product->size->offer->value)*$product->amount}}
                                                                    جنيه
                                                                </td>
                                                                @break
                                                            @endswitch
                                                        @endisset
                                                    </tr>


                                                @endforeach
                                            @endisset
                                            
                                                <tr>
                                                    <div class="row" style="margin-right: 0.5em">

                                                        <h4> الاجمالى: </h4>
                                                        @if ($orderProducts->first()->type == "app")
                                                        <h4 style="color: red;margin-right: 1em">{{$orderProducts->first()->orderRel->price_after_discount}}
                                                            جنيه </h4>
                                                            @else
                                                            <h4 style="color: red;margin-right: 1em">{{$orderProducts->first()->adminOrderRel->total_price}}
                                                                جنيه </h4>
                                                            @endif
                                                    </div>
                                                </tr>
                                            </tbody>
                                        </table>


                                    </div>


                                </div>
                                @if ($orderProducts->first()->type == "app")
                                @if($orderProducts->first()->orderRel->status==1)
                                    <div id="order_actions" class="form-actions" style="text-align: center">
                                        <a href="{{route("accept.order",[$orderProducts->first()->orderRel->id,
                                        $orderProducts->first()->type])}}"
                                           type="submit" class="btn btn-success ">
                                            <i class="la la-check-square-o"></i>قبول
                                        </a>
                                        <a href="{{route("reject.order", [$orderProducts->first()->orderRel->id,
                                        $orderProducts->first()->type])}}"
                                           type="button" class="btn btn-danger mr-1" style="color: white">
                                            <i class="ft-x"></i> رفض
                                        </a>

                                    </div>
                                @endif
                                @else
                                @if($orderProducts->first()->adminOrderRel->status==1)
                                <div id="order_actions" class="form-actions" style="text-align: center">
                                    <a href="{{route("accept.order",[$orderProducts->first()->adminOrderRel->id,
                                    $orderProducts->first()->type])}}"
                                       type="submit" class="btn btn-success ">
                                        <i class="la la-check-square-o"></i>قبول
                                    </a>
                                    <a href="{{route("reject.order",[$orderProducts->first()->adminOrderRel->id, $orderProducts->first()->type])}}"
                                       type="button" class="btn btn-danger mr-1" style="color: white">
                                        <i class="ft-x"></i> رفض
                                    </a>

                                </div>
                                @endif
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
