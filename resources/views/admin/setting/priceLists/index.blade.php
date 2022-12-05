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
                            <p style="font-weight: bold; font-size: 18px"> قائمة الأسعار</p>

                            <a href="{{route("priceLists.add")}}"
                            class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1 ">إضافة قائمة أسعار جديدة</a>
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
                                    <th>اسم النوع</th>
                                    <th>سعر الكيلو</th>
                                    <th>سعر الدقيقة</th>
                                    <th>سعر بداية التحرك</th>
                                    <th>الاجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($priceLists)
                                    @foreach($priceLists as $priceList)
                                        <tr>
                                            <th scope="row">{{$priceList->id}}</th>
                                            <td>{{ $priceList->name }}</td>
                                            <td>{{ $priceList->kilo_price }}</td>
                                            <td>{{ $priceList->minute_price }}</td>
                                            <td>{{ $priceList->start_price }}</td>
                                            <td>
                                                <div class="btn-group" role="group"
                                                     aria-label="Basic example">
                                                    <a href="{{route("priceLists.edit",$priceList->id)}}"
                                                       class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>

                                                </div>
                                            </td>
                                           


                                        </tr>

                                    @endforeach
                                @endisset

                                </tbody>
                            </table>
                            @if($priceLists->hasPages())
                            <ul class="pager pager-flat">

                                <li class="{{$priceLists->onFirstPage()?'disabled':"enabled"}}">
                                    <a href="{{$priceLists->previousPageUrl()}}"  onclick="{{$priceLists->onFirstPage()?"return false;":""}}" ><i class="ft-arrow-left"></i> السابق</a>
                                </li>


                                <li class="{{$priceLists->hasMorePages()?'enabled':"disabled"}} ">
                                    <a href="{{$priceLists->nextPageUrl()}}" onclick="{{$priceLists->hasMorePages()?"":"return false;"}}" >التالى <i class="ft-arrow-right"></i></a>
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
