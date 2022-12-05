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
                            <p style="font-weight: bold; font-size: 18px">اضافه عروض للمنتجات</p>
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
                            <table id="prod-table" class="table">
                                <thead class="bg-primary white">
                                <tr>
                                    <th>#</th>
                                    <th>اسم المنتج</th>
                                    <th>الاحجام</th>

                                </tr>
                                </thead>
                                <tbody>
                                @isset($products)
                                    @foreach($products as $product)
                                        <tr>
                                            <th scope="row">{{$product->id}}</th>

                                            <td>{{$product->name_ar}}</td>
                                            <td>
                                                <table id="prod-tb" class="table table-borderless">
                                                    <thead >
                                                    <th> الحجم</th>
                                                    <th>السعر</th>
                                                    <th>العرض</th>
                                                    <th>تاريخ الانتهاء</th>
                                                    <th>الاجراءات</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach(\App\Models\shop\SizePrice::where("product_id",$product->id)->get() as $size)
                                                        <tr>
                                                            <td>{{$size->name}}</td>
                                                            <td>{{$size->price}}</td>

                                                            <td>{{$size->offer!=null?$size->offer->name:""}}</td>
                                                            <td>{{$size->offer!=null?$size->offer->expire_date:""}}</td>
                                                            <td>
                                                                <div class="btn-group" role="group"
                                                                     aria-label="Basic example">
                                                                    @if($size->offer)
                                                                        <a href="{{route("edit.shop.offer",$size->offer)}}"
                                                                           class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>

                                                                        <a  href="{{route("delete.shop.offer",[$size->id,$size->offer->id])}}"
                                                                            class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>

                                                                    @else
                                                                        <a  href="{{route("add.shop.offer",$size->id)}}"
                                                                            class="btn btn-outline-success btn-min-width box-shadow-3 mr-1 mb-1">اضافه عرض</a>
                                                                    @endif
                                                                </div>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </td>



                                        </tr>

                                    @endforeach
                                @endisset

                                </tbody>
                            </table>
                            @if($products->hasPages())
                            <ul class="pager pager-flat">

                                <li class="{{$products->onFirstPage()?'disabled':"enabled"}}">
                                    <a href="{{$products->previousPageUrl()}}"  onclick="{{$products->onFirstPage()?"return false;":""}}" ><i class="ft-arrow-left"></i> السابق</a>
                                </li>


                                <li class="{{$products->hasMorePages()?'enabled':"disabled"}} ">
                                    <a href="{{$products->nextPageUrl()}}" onclick="{{$products->hasMorePages()?"":"return false;"}}" >التالى <i class="ft-arrow-right"></i></a>
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
