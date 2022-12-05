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
                                    <th>الاسم</th>
                                    <th> البريد الإلكتروني</th>
                                    <th>الصلاحيات </th>

                                    <th>الاجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($admins)
                                @foreach($admins as $key => $admin)
                                <tr>
                                    <th scope="row">{{ $admin->id}}</th>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>
                                        @if(!empty($admin->getRoleNames()))
                                        @foreach($admin->getRoleNames() as $v)
                                        <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{route("admin.edit",$admin->id)}}"
                                                class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1
                                                mb-1">تعديل</a>
                                            <a href="{{route("admin.delete",$admin->id)}}"
                                                class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1
                                                mb-1">حذف</a>
                                            <a href="{{route("admin.wallet",$admin->id)}}"
                                                class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1
                                                mb-1">المحفظة</a>

                                        </div>
                                    </td>


                                </tr>

                                @endforeach
                                @endisset

                            </tbody>
                        </table>
                        @if($admins->hasPages())
                        <ul class="pager pager-flat">

                            <li class="{{$admins->onFirstPage()?'disabled':" enabled"}}">
                                <a href="{{$admins->previousPageUrl()}}" onclick="{{$admins->onFirstPage()?" return
                                    false;":""}}"><i class="ft-arrow-left"></i> السابق</a>
                            </li>


                            <li class="{{$admins->hasMorePages()?'enabled':" disabled"}} ">
                                    <a href=" {{$admins->nextPageUrl()}}" onclick="{{$admins->hasMorePages()?"":"return
                                false;"}}" >التالى <i class="ft-arrow-right"></i></a>
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