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
                            <p style="font-weight: bold; font-size: 18px">موديلات السيارات</p>
                            <a href="{{route("carModels.add")}}"
                                class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">إضافة موديل جديد</a>
                            
                        </div>

                        <form action="{{ route('importCarModels') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-3"> 
                                    <input type="file" name="file" class="form-control">
                                </div>
                                <div class="col-md-3"> 
                                    <button class="btn btn-info">إضافة موديلات جديدة</button>
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
                                    <th>اسم الموديل</th>
                                    <th>اسم الماركة</th>
                                    <th>الصوره</th>

                                    <th>الاجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($car_models)
                                    @foreach($car_models as $model)
                                        <tr>
                                            <th scope="row">{{$model->id}}</th>
                                            <td>{{ $model->model }}</td>
                                            <th scope="row">{{$model->marker}}</th>
                                            <td>
                                                <div>
                                                    <img class="category-image" src="{{asset("$model->image")}}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group"
                                                     aria-label="Basic example">
                                                    <a href="{{route("carModels.edit",$model->id)}}"
                                                       class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                    <a  href="{{route("carModels.delete",$model->id)}}"
                                                        class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>

                                                </div>
                                            </td>


                                        </tr>

                                    @endforeach
                                @endisset

                                </tbody>
                            </table>
                            @if($car_models->hasPages())
                            <ul class="pager pager-flat">

                                <li class="{{$car_models->onFirstPage()?'disabled':"enabled"}}">
                                    <a href="{{$car_models->previousPageUrl()}}"  onclick="{{$car_models->onFirstPage()?"return false;":""}}" ><i class="ft-arrow-left"></i> السابق</a>
                                </li>


                                <li class="{{$car_models->hasMorePages()?'enabled':"disabled"}} ">
                                    <a href="{{$car_models->nextPageUrl()}}" onclick="{{$car_models->hasMorePages()?"":"return false;"}}" >التالى <i class="ft-arrow-right"></i></a>
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
