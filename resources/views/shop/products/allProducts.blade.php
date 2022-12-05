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
                            <p style="font-weight: bold; font-size: 18px">المنتجات</p>
                        </div>
                        @include("alert.success")
                        @if(Session::has('error'))
                            <div class="row mr-2 ml-2">
                                <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                        id="type-error">{{Session::get('error')}}
                                </button>
                            </div>
                        @endif

                        <div  style="overflow: auto" class="table-responsive-sm">
                            <table class="table" >
                                <thead class="bg-primary white">
                                <tr>
                                    <th>#</th>

                                    <th>الصورة</th>
                                    <th>الاسم العربى</th>
                                    <th>الاسم الانجليزى</th>
                                    <th>المواصفات</th>
                                    <th>الاجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($products)
                                    @foreach($products as $product)
                                        <tr>
                                            <th scope="row">{{$product->id}}</th>
                                            <td>
                                                <div>
                                                    <img class="category-image" src="{{asset( $product->image!=null?"$product->image":"app-assets/images/default_product.png")}}">
                                                </div>
                                            </td>
                                            <td>{{$product->name_ar}}</td>
                                            <td>{{$product->name_en}}</td>
                                            <td>
                                                <table class="table-borderless">
                                                    <thead class="text-danger">
                                                        <tr>
        
                                                            <th>الحجم</th>
                                                            <th>السعر</th>
        
                                                        </tr>
                                                    </thead>
                                                    <tbody>
        
                                                        @foreach ($product->sizes as $size)
                                                            <tr>
                                                                <td>{{ $size->name }}</td>
                                                                <td>{{ $size->price }}</td>
                                                            </tr>
                                                        @endforeach
        
        
                                                    </tbody>
                                                </table>
                                            </td>

                                            {{-- <td><div style="width: 200px">{{$product->description_ar}}</div></td> --}}
                                            {{-- <td>{{$product->description_en}}</td> --}}

                                            {{-- <td>{{$product->active==1?"مفعل":"غير مفعل"}}</td> --}}

                                            <td>
                                                <div class="btn-group" role="group"
                                                     aria-label="Basic example">
                                                    <a href="{{route("edit.product",$product->id)}}"
                                                       class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                    <a  href="{{route("delete.product",$product->id)}}"
                                                        class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>

                                                </div>
                                            </td>


                                        </tr>

                                    @endforeach
                                @endisset

                                </tbody>
                            </table>
                            @if ($products->hasPages())
                            <ul class="pager pager-flat">

                                <li class="{{ $products->onFirstPage() ? 'disabled' : 'enabled' }}">
                                    <a href="{{ $products->previousPageUrl() }}"
                                        onclick="{{ $products->onFirstPage() ? 'return false;' : '' }}"><i
                                            class="ft-arrow-left"></i> السابق</a>
                                </li>

                                <li class="{{ $products->hasMorePages() ? 'enabled' : 'disabled' }} ">
                                    <a href="{{ $products->nextPageUrl() }}"
                                        onclick="{{ $products->hasMorePages() ? '' : 'return false;' }}">التالى <i
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
