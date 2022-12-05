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
                            <p style="font-weight: bold; font-size: 18px">عروض شاور</p>
                        </div>
                        @include("alert.success")
                        @if(Session::has('error'))
                            <div class="row mr-2 ml-2">
                                <button type="text" class="btn btn-lg btn-block btn-outline-danger mb-2"
                                        id="type-error">{{Session::get('error')}}
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-primary white">
                                <tr>
                                    <th>#</th>
                                    <th>الصوره</th>
                                    <th>تاريخ الانتهاء</th>

                                    <th>الحاله</th>



                                    <th>الاجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($offers)
                                    @foreach($offers as $offer)
                                        <tr>
                                            <th scope="row">{{$offer->id}}</th>
                                            <td>
                                                <div>
                                                    <img class="category-image" src="{{asset($offer->image)}}">
                                                </div>
                                            </td>



                                            <td>{{$offer->expireDate}}</td>
                                            <td>{{$offer->active==1?"مفعل":"غير مفعل"}}</td>

                                            <td>
                                                <div class="btn-group" role="group"
                                                     aria-label="Basic example">

                                                    <a  href="{{route('delete.offer',['id'=>$offer->id])}}"
                                                        class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>

                                                </div>
                                            </td>


                                        </tr>

                                    @endforeach
                                @endisset

                                </tbody>
                            </table>
                            @if($offers->hasPages())
                                <ul class="pager pager-flat">

                                    <li class="{{$offers->onFirstPage()?'disabled':"enabled"}}">
                                        <a href="{{$offers->previousPageUrl()}}"  onclick="{{$offers->onFirstPage()?"return false;":""}}" ><i class="ft-arrow-left"></i> السابق</a>
                                    </li>


                                    <li class="{{$offers->hasMorePages()?'enabled':"disabled"}} ">
                                        <a href="{{$offers->nextPageUrl()}}" onclick="{{$offers->hasMorePages()?"":"return false;"}}" >التالى <i class="ft-arrow-right"></i></a>
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
