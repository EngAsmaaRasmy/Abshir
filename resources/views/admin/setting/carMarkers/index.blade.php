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
                            <p style="font-weight: bold; font-size: 18px">ماركات السيارات</p>

                            <a href="{{route("carMarkers.add")}}"
                            class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1 ">إضافة ماركة جديدة</a>
                        </div>

                        <form action="{{ route('importCarMarkers') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3"> 
                                    <input type="file" name="file" class="form-control">
                                </div>
                                <div class="col-md-3"> 
                                    <button class="btn btn-info">إضافة ماركات جديدة</button>
                                </div>
                            </div>
                            <br>
                            
                        </form>
                        

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
                                    <th>اسم الماركة</th>
                                    <th>الصوره</th>

                                    <th>الاجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($car_markers)
                                    @foreach($car_markers as $marker)
                                        <tr>
                                            <th scope="row">{{$marker->id}}</th>
                                            <td>{{ $marker->marker }}</td>
                                            <td>
                                                <div>
                                                    <img class="category-image" src="{{asset("$marker->image")}}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group"
                                                     aria-label="Basic example">
                                                    <a href="{{route("carMarkers.edit",$marker->id)}}"
                                                       class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                    <a  href="{{route("carMarkers.delete",$marker->id)}}"
                                                        class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>

                                                </div>
                                            </td>
                                           


                                        </tr>

                                    @endforeach
                                @endisset

                                </tbody>
                            </table>
                            @if($car_markers->hasPages())
                            <ul class="pager pager-flat">

                                <li class="{{$car_markers->onFirstPage()?'disabled':"enabled"}}">
                                    <a href="{{$car_markers->previousPageUrl()}}"  onclick="{{$car_markers->onFirstPage()?"return false;":""}}" ><i class="ft-arrow-left"></i> السابق</a>
                                </li>


                                <li class="{{$car_markers->hasMorePages()?'enabled':"disabled"}} ">
                                    <a href="{{$car_markers->nextPageUrl()}}" onclick="{{$car_markers->hasMorePages()?"":"return false;"}}" >التالى <i class="ft-arrow-right"></i></a>
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
