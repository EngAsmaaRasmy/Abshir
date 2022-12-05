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
                            <p style="font-weight: bold; font-size: 18px">الاقسام</p>
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
                                    <th>الاسم العربى</th>
                                    <th>الاسم الانجليزى</th>
                                    <th>الاجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($categories)
                                    @foreach($categories as $category)
                                        <tr>
                                            <th scope="row">{{$category->id}}</th>

                                            <td>{{$category->name_ar}}</td>
                                            <td>{{$category->name_en}}</td>
                                            <td>
                                                <div class="btn-group" role="group"
                                                     aria-label="Basic example">
                                                    <a href="{{route("display.categories.edit.form",$category->id)}}"
                                                       class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                    <a  href="{{route("shop.category.delete",$category->id)}}"
                                                        class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>

                                                </div>
                                            </td>


                                        </tr>

                                    @endforeach
                                @endisset

                                </tbody>
                            </table>
                            @if($categories->hasPages())
                            <ul class="pager pager-flat">

                                <li class="{{$categories->onFirstPage()?'disabled':"enabled"}}">
                                    <a href="{{$categories->previousPageUrl()}}"  onclick="{{$categories->onFirstPage()?"return false;":""}}" ><i class="ft-arrow-left"></i> السابق</a>
                                </li>


                                <li class="{{$categories->hasMorePages()?'enabled':"disabled"}} ">
                                    <a href="{{$categories->nextPageUrl()}}" onclick="{{$categories->hasMorePages()?"":"return false;"}}" >التالى <i class="ft-arrow-right"></i></a>
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
