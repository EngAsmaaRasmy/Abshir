@extends("admin.app")
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
                            <p style="font-weight: bold; font-size: 18px">الكوبونات</p>
                        </div>
                        @include("alert.success")
                        @if(Session::has('error'))
                            <div class="row mr-2 ml-2">
                                <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                        id="type-error">{{Session::get('error')}}
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive-sm"  style="overflow: auto" >
                            <table class="table" >
                                <thead class="bg-primary white">
                                <tr>
                                    <th>#</th>
                                    <th>الكوبون</th>
                                    <th>المحل</th>
                                    <th>القيمة</th>
                                    <th>النسبة</th>
                                    <th>اقصى عدد للاستخدام</th>
                                    <th>عدد المستخدمين المستفيدين</th>
                                    <th>الحد الادنى</th>
                                    <th>تاريخ الانتهاء</th>

                                    <th>الاجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($coupons)
                                    @foreach($coupons as $coupon)
                                        <tr>
                                            <th scope="row">{{$coupon->id}}</th>

                                            <td>{{$coupon->name}}</td>
                                            <td> {{isset($coupon->shopRelation)? $coupon->shopRelation->name:""}}</td>
                                            <td>{{$coupon->value}}  ريال </td>
                                            <td>{{$coupon->percentage}} %</td>
                                            <td>{{$coupon->max_count}}</td>
                                            <td>{{$coupon->current_count}}</td>
                                            <td>{{$coupon->minimum_order}}</td>
                                            <td>{{$coupon->expire_date}}</td>
                                            <td>
                                                <div class="btn-group" role="group"
                                                     aria-label="Basic example">
                                                    <a href="{{route("coupons.edit",$coupon->id)}}"
                                                       class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                    <a  href="{{route("coupons.delete",$coupon->id)}}"
                                                        class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>

                                                </div>
                                            </td>


                                        </tr>

                                    @endforeach
                                @endisset

                                </tbody>
                            </table>
                            @if($coupons->hasPages())
                            <ul class="pager pager-flat">

                                <li class="{{$coupons->onFirstPage()?'disabled':"enabled"}}">
                                    <a href="{{$coupons->previousPageUrl()}}"  onclick="{{$coupons->onFirstPage()?"return false;":""}}" ><i class="ft-arrow-left"></i> السابق</a>
                                </li>


                                <li class="{{$coupons->hasMorePages()?'enabled':"disabled"}} ">
                                    <a href="{{$coupons->nextPageUrl()}}" onclick="{{$coupons->hasMorePages()?"":"return false;"}}" >التالى <i class="ft-arrow-right"></i></a>
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
