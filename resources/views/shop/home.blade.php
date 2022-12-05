@php($user=\Illuminate\Support\Facades\Auth::user())
@extends("shop.app")
@section("content")
    <div  class="app-content content " >
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- eCommerce statistic -->

                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="info">{{$todayOrdersCount}}</h3>
                                            <h6>عدد طلبات اليوم</h6>
                                        </div>
                                        <div>
                                            <i class="icon-basket-loaded info font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content ">
                                <div class="card-body " >
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="warning">{{$todayOrdersTotalPrice}} جنيه</h3>
                                            <h6>اجمالى مبيعات اليوم</h6>
                                        </div>
                                        <div>
                                            <i class="ft-dollar-sign warning font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="success">{{$user->order_count}}</h3>
                                            <h6>عدد الطلبات الكلى</h6>
                                        </div>
                                        <div>
                                            <i class="fa fa-bank success font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="media-body text-left">
                                            <h3 class="danger"> {{$user->total_earnings}} جنيه</h3>
                                            <h6>اجمالى المبيعات</h6>
                                        </div>
                                        <div>
                                            <i class="fa fa-motorcycle danger font-large-2 float-right"></i>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                        <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ eCommerce statistic -->
                <shop-delivered-orders></shop-delivered-orders>
                <div class="card">

                    <div class="card-content collapse show">
                        <div class="card-body">
                            <p style="font-weight: bold; font-size: 18px">المنتجات الاكثر طلبا</p>
                        </div>
                        <div class="table-responsive-sm">
                            <table class="table">
                                <thead class="bg-primary white">
                                <tr>
                                    <th>#</th>
                                    <th>صوره المنتج </th>
                                    <th>اسم المنتج</th>
                                    <th>عدد الطلبات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($mostOrdersProducts)
                                    @foreach($mostOrdersProducts as $order)
                                <tr>
                                    <th scope="row">{{$order->id}}</th>
                                    <td>
                                        <div>
                                            <img style="object-fit: fill" class="category-image" src="{{$order->image?asset($order->image): asset('app-assets/images/default_product.png')}}">
                                        </div>
                                    </td>
                                    <td>{{$order->name_ar}}</td>

                                    <td>{{$order->count}}</td>
                                </tr>
                                    @endforeach
                              @endisset



                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
