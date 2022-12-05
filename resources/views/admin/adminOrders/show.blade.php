@extends('admin.app')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">


                <div class="card">

                    <div class="card-content collapse show">
                        <div class="card-body d-flex justify-content-between">
                            <p style="font-weight: bold; font-size: 18px">الطلبات الخاصة</p>
                            {{-- <a href="{{ route('customerOrders') }}"
                                class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">طلبات التطبيق
                            </a> --}}
                        </div>
                        @include('alert.success')
                        @if (Session::has('error'))
                            <div class="row mr-2 ml-2">
                                <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                    id="type-error">{{ Session::get('error') }}
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive-sm" style="overflow: auto">
                            <table id="order-tb" class="table">
                                <thead class="bg-primary white">
                                    <tr>
                                        <th>#</th>
                                        {{-- <th>المحل</th> --}}
                                        <th>تفاصيل الطلب</th>
                                        <th>اسم العميل </th>
                                        <th>هاتف العميل</th>
                                        <th> عنوان العميل</th>
                                        <th>  بواسطة</th>
                                        <th>الاجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($orders)
                                        @foreach ($orders as $order)
                                            <tr>
                                                <th scope="row">{{ $order->id }}</th>
                                                 <td>{{ $order->details ?? '-------' }}</td>
                                                 <td>{{ $order->customer_name ?? $order->customerRrl->fullname }}</td>
                                                {{-- <td>{{ $order->adminShop->name ?? '-------' }}</td> --}}
                                                {{-- <td>
                                                    <table id="prod-tb" class="table table-borderless">
                                                        <thead class="text-danger">
                                                            <th> المنتج</th>
                                                            <th>الحجم</th>
                                                            <th>الكمية</th>
                                                        </thead>
                                                        <tbody class="text-center">
                                                            @foreach (\App\Models\OrderProduct::where('order', $order->id)->get() as $orderProduct)
                                                                <tr>
                                                                    <td>{{ $orderProduct->productRel->name_ar ?? '' }}</td>
                                                                    <td>{{ $orderProduct->size->name ?? '' }}</td>

                                                                    <td>{{ $orderProduct->amount ?? '' }}</td>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table> 
                                </td> --}}
                                {{-- <td>{{ $order->driver != null ? $order->driver->phone : '-------' }}</td> --}}

                                <td>{{ $order->customer_phone ?? $order->customerRrl->phone }}</td>
                                <td>{{ $order->customer_address ?? '--------'}}</td>
                                <td>
                                    @if ($order->type == "adminOrder")
                                         لوحة التحكم
                                    @elseif ($order->type == "specialOrder")
                                     خلال التطبيق
                                    @endif
                                </td>
                                {{-- <td>
                                    @if ($order->status == 1)
                                        <p style="color: orange">قيد المراجعة</p>
                                    @elseif ($order->status == 2)
                                        <p style="color: green">قيد المعالجة</p>
                                    @elseif ($order->status == 3)
                                        <p class="text-primary">جاهز للتوصيل </p>
                                    @elseif ($order->status == 4)
                                        <p class="text-success">في الطريق </p>
                                    @endif
                                </td> --}}
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('order.edit', $order->id) }}"
                                            class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1
                                                            mb-1 @if($order->type == "specialOrder") disabled  @endif">تعديل</a>
                                    </div>
                                </td>

                                </tr>
                                @endforeach
                            @endisset

                            </tbody>
                            </table>
                            @if ($orders->hasPages())
                                <ul class="pager pager-flat">

                                    <li class="{{ $orders->onFirstPage() ? 'disabled' : 'enabled' }}">
                                        <a href="{{ $orders->previousPageUrl() }}"
                                            onclick="{{ $orders->onFirstPage() ? 'return false;' : '' }}"><i
                                                class="ft-arrow-left"></i> السابق</a>
                                    </li>


                                    <li class="{{ $orders->hasMorePages() ? 'enabled' : 'disabled' }} ">
                                        <a href="{{ $orders->nextPageUrl() }}"
                                            onclick="{{ $orders->hasMorePages() ? '' : 'return false;' }}">التالى <i
                                                class="ft-arrow-right"></i></a>
                                    </li>


                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
