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
                        <div class="card-body row">
                            <div class="col-md-6">
                                <p style="font-weight: bold; font-size: 18px">الطلبات الخاصة بالتطبيق</p>
                            </div>
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
                                        <th>المحل</th>
                                        <th>المنتجات</th>
                                        <th> العميل</th>
                                        <th> اجمالي السعر </th>
                                        <th>حالة الطلب</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($orders)
                                        @foreach ($orders as $order)
                                            <tr>
                                                <th scope="row">{{ $order->id }}</th>
                                                <td>{{ $order->getRelationValue('shop')->name ?? '------' }}</td>
                                                <td>
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
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>
                                                    <table id="prod-tb" class="table table-borderless">
                                                        <thead class="text-danger">
                                                            <th> اسم العميل</th>
                                                            <th>رقم الهاتف</th>
                                                        </thead>
                                                        <tbody class="text-center">
                                                            <tr>
                                                                <td>{{ $order->customerRel->name ?? '' }}</td>
                                                                <td>{{ $order->customerRel->phone ?? '' }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>{{ $order->total_price }} جنيه </td>
                                                <td>
                                                    @if ($order->status == 1)
                                                        <p class="text-info">قيد المراجعة</p>
                                                    @elseif ($order->status == 2)
                                                        <p class="text-secondary">قيد المعالجة</p>
                                                    @elseif ($order->status == 3)
                                                        <p class="text-primary">جاهز للتوصيل </p>
                                                    @elseif ($order->status == 4)
                                                        <p class="text-success">في الطريق </p>
                                                    @endif
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
