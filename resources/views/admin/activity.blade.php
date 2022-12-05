@extends("admin.app")
@section("content")
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="card p-2">
                    <form method="post" action="{{route("activity.search")}}" enctype="multipart/form-data" >
                        @csrf
                        <div class="card-content collapse show">
                        <div class="card-body d-flex justify-content-between">
                            <p style="font-weight: bold; font-size: 18px"> أنشطة المستخدمين</p>
                            <div class="mx-4">
                                <ul data-v-7962e2ec="" role="group"
                                    class="nav nav-pills nav-pills-rounded chart-action float-right btn-group"
                                    style="margin-bottom: 1em;">
                                    
                                        <li data-v-7962e2ec="" class="nav-item mx-2"><input class="form-control" type="date" name="start_date" required/></li>
                                        <li data-v-7962e2ec="" class="nav-item mx-2"><input class="form-control" type="date" name="end_date" required/></li>
                                        <li data-v-7962e2ec="" class="nav-item mx-2"> <button type="submit" class="btn btn-primary">
                                            <i class="la la-search"></i> فلترة
                                        </button></li>
                                   
                                </ul>
                            </div>
                        </div>
                        <hr>
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
                                <thead class="bg-primary white text-center">
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>  نوع التغيير</th>
                                    <th>المكان الذى حدث فيه التغيير</th>
                                    <th>الرقم</th>
                                    <th>ما حدث تغيير فيه</th>
                                    <th>القيمة القديمة</th>
                                    <th>القيمة الجديدة </th>
                                    <th>تاريخ الإضافة</th>
                                </tr>
                                </thead>
                                <tbody>
                                @isset($activities)
                                    @foreach($activities as $key => $activity)
                                        <tr>
                                            <th scope="row">{{ $activity->id}}</th>
                                            <td>{{ $activity->name}}</td>
                                            <td>{{ $activity->description }}</td>
                                            <td>{{ $activity->subject_type }}</td>
                                            <td>{{ $activity->subject_id }}</td>
                                            <td>
                                                @isset ($activity->changes['attributes'])
                                                    @foreach ($activity->changes['attributes'] as $key => $diff)
                                                        <label class="badge badge-info px-1" style="font-size: 16px;">{{$key}}</label>
                                                    @endforeach
                                                @endisset
                                            </td>
                                            <td>
                                                @isset ($activity->changes['old'])
                                                    @foreach ($activity->changes['old'] as $old)
                                                        <label class="badge badge-secondary px-1" style="font-size: 16px;">{{$old}}</label> 
                                                    
                                                    @endforeach
                                                @endisset
                                                
                                            </td>
                                            <td>
                                                @isset ($activity->changes['attributes'])
                                                    @foreach ($activity->changes['attributes'] as $new)
                                                        <label class="badge badge-dark px-1" style="font-size: 16px;">{{$new}}</label>
                                                    
                                                    @endforeach
                                                @endisset
                                            <td>
                                            {{$activity->created_at}}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset

                                </tbody>
                            </table>
                            @if($activities->hasPages())
                            <ul class="pager pager-flat">

                                <li class="{{$activities->onFirstPage()?'disabled':"enabled"}}">
                                    <a href="{{$activities->previousPageUrl()}}"  onclick="{{$activities->onFirstPage()?"return false;":""}}" ><i class="ft-arrow-left"></i> السابق</a>
                                </li>


                                <li class="{{$activities->hasMorePages()?'enabled':"disabled"}} ">
                                    <a href="{{$activities->nextPageUrl()}}" onclick="{{$activities->hasMorePages()?"":"return false;"}}" >التالى <i class="ft-arrow-right"></i></a>
                                </li>


                            </ul>

                                @endif

                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
