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
                        <div class="card-body d-flex justify-content-between">
                            <p style="font-weight: bold; font-size: 18px">  إعدادات الخصم</p>

                            <a href="{{route("discountSettings.add")}}"
                            class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1 ">إضافة خصم جديد</a>
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
                                    <th>نوع الخصم</th>
                                    <th>قيمة الخصم </th>
                                    <th>الإجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($discounts)
                                    @foreach($discounts as $discount)
                                        <tr>
                                            <th scope="row">{{$discount->id}}</th>
                                            @if ( $discount->name == "driver")
                                            <td>سائق</td>
                                            @elseif ($discount->name == "customer")
                                            <td>عميل</td>
                                            @endif
                                            <td>{{ $discount->discount_value }}</td>
                                            <td>
                                                <div class="btn-group" role="group"
                                                     aria-label="Basic example">
                                                    <a href="{{route("discountSettings.edit",$discount->id)}}"
                                                       class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>

                                                </div>
                                            </td>
                                           


                                        </tr>

                                    @endforeach
                                @endisset

                                </tbody>
                            </table>
                            @if($discounts->hasPages())
                            <ul class="pager pager-flat">

                                <li class="{{$discounts->onFirstPage()?'disabled':"enabled"}}">
                                    <a href="{{$discounts->previousPageUrl()}}"  onclick="{{$discounts->onFirstPage()?"return false;":""}}" ><i class="ft-arrow-left"></i> السابق</a>
                                </li>


                                <li class="{{$discounts->hasMorePages()?'enabled':"disabled"}} ">
                                    <a href="{{$discounts->nextPageUrl()}}" onclick="{{$discounts->hasMorePages()?"":"return false;"}}" >التالى <i class="ft-arrow-right"></i></a>
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
