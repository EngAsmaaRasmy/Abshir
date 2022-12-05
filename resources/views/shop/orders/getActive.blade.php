@extends("shop.app")
@section("content")
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">


                <div class="card">

                    <div class="card-content collapse show">
                        <div class="card-body">
                            <p style="font-weight: bold; font-size: 18px">طلبات قيد التنفيذ</p>
                        </div>
                        @include("alert.success")
                        @if(Session::has('error'))
                            <div class="row mr-2 ml-2">
                                <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                        id="type-error">{{Session::get('error')}}
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive-sm">
                            <table class="table">
                                <thead class="bg-primary white">
                                <tr>
                                    <th>#</th>
                                    <th>العميل</th>

                                    <th>المنتجات</th>
                                    <th>اجمالى السعر</th>
                                    <th>الحالة</th>
                                    <th>الاجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($activeOrders)
                                    @foreach($activeOrders as $order)
                                        <tr>
                                            <th scope="row">{{$order->id}}</th>

                                            <td>{{$order->customerRel->name ?? $order->customer_name }}</td>
                                            <td>
                                             <table id="prod-tb" class="table table-borderless">
                                                 <thead >
                                                 <th> اسم المنتج</th>
                                                 <th>الكميه</th>
                                                 <th>السعر</th>
                                                 </thead>
                                                 <tbody>
                                                 @foreach(\App\Models\OrderProduct::where("order",$order->id)->get() as $orderProduct)
                                                 <tr>
                                                  <td>{{$orderProduct->getRelationValue('productRel')->name_ar}}</td>
                                                     <td>{{$orderProduct->amount}}</td>
                                                     <td>{{$orderProduct->getRelationValue("productRel")->price }}  جنيه </td>
                                                 </tr>
                                                 @endforeach
                                                 </tbody>
                                             </table>
                                            </td>
                                            <td>{{$order->total_price}} جنيه </td>
                                            <td>@if ($order->status == 1)
                                                <p style="color: orange">قيد المراجعة</p>
                                            @elseif ($order->status == 2)
                                                <p  style="color: green">قيد المعالجة</p>
                                            @elseif ($order->status == 3)
                                                <p class="text-primary">جاهز للتوصيل </p>
                                            @elseif ($order->status == 4)
                                                <p class="text-success">في الطريق </p>
                                            @endif</td>
                                            <td>
                                                <div class="btn-group" role="group"
                                                     aria-label="Basic example">

                                                    <a  href="{{route("self.delivery",$order->id)}}"
                                                        class="btn btn-outline-success btn-mid-width box-shadow-3 mr-1 mb-1">توصيل المحل</a>
                                                    <a  href="{{route("send.order.ToDriver",$order->id)}}"
                                                        class="btn btn-outline-danger btn-mid-width box-shadow-3 mr-1 mb-1">توصيل أبشر</a>

                                                </div>
                                            </td>


                                        </tr>

                                    @endforeach
                                @endisset

                                </tbody>
                            </table>
                            {{-- @if($activeOrders->hasPages())
                            <ul class="pager pager-flat">

                                <li class="{{$activeOrders->onFirstPage()?'disabled':"enabled"}}">
                                    <a href="{{$activeOrders->previousPageUrl()}}"  onclick="{{$activeOrders->onFirstPage()?"return false;":""}}" ><i class="ft-arrow-left"></i> السابق</a>
                                </li>

                                <li class="{{$activeOrders->hasMorePages()?'enabled':"disabled"}} ">
                                    <a href="{{$activeOrders->nextPageUrl()}}" onclick="{{$activeOrders->hasMorePages()?"":"return false;"}}" >التالى <i class="ft-arrow-right"></i></a>
                                </li>


                            </ul>

                                @endif --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
