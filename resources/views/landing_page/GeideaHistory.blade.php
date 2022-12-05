@extends("admin.app")
@section("content")
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة عميل جديد </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <form method="post" role="form" action="{{route('balance.withdrawal')}}">
                    {{ csrf_field() }}
                    <div class="">
                        <div class="card">
                            <div class="card-body">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                               
                                <div class="form-group">
                                    <label>قيمة السحب</label>
                                    <input type="text" class="form-control" id="balance" required name="balance">
                                </div>
                               
                            </div>
                        </div>
                        <div class="modal-footer d-block">
                            <button type="submit" id="addClint" class="btn btn-warning float-right">حفظ</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>


<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="content-wrapper ">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="card p-2">
                
                <div class="card-body d-flex justify-content-between">
                    <p style="font-weight: bold; font-size: 18px"> Geidea احصائيات</p>
                    @if(isset($geideaAccountBalance))
                    <div class="mx-4">
                        <ul data-v-7962e2ec="" role="group"
                            class="nav nav-pills nav-pills-rounded chart-action float-right btn-group"
                            style="margin-bottom: 1em;">
                            <li data-v-7962e2ec="" class="nav-item mx-2">رصيد المحفظة</li>
                            <li data-v-7962e2ec="" class="nav-item mx-1"><input class="form-control" type="text"
                                    name="balance" value="{{$geideaAccountBalance->balance}}" readonly /></li>

                            <li data-v-7962e2ec="" class="nav-item mx-2">
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#myModal">سحب من المحفظة
                                </button>
                            </li>

                        </ul>
                    </div>
                    @endif
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
                        <thead class="bg-primary white text-center">
                            <tr>
                                <th>#</th>
                                <th>الرحلة</th>
                                <th>قيمة الاضافه</th>
                                <th>النوع</th>
                                <th>اضافه بواسطة</th>
                                <th>تاريخ الإضافة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($geideaHistories)
                            @foreach($geideaHistories as $key => $history)
                            <tr>
                                <th scope="row">{{ $history->id}}</th>
                                <td>@if(is_null($history->trip_id ))  @else {{$history->trip_id}}@endif </td>

                                <td>@if(is_null($history->value ))  @else {{ $history->value }}@endif</td>
                                <td>@if($history->type == "Add") إضافه@else خصم@endif</td>
                                <td>@if( $history->user_type == "Admin")أدمن @else ابلكيشن @endif</td>
                                <td>{{ $history->created_at}}</td>
                            </tr>
                            @endforeach
                            @endisset

                        </tbody>
                    </table>
                    @if($geideaHistories->hasPages())
                    <ul class="pager pager-flat">

                        <li class="{{$geideaHistories->onFirstPage()?'disabled':" enabled"}}">
                            <a href="{{$geideaHistories->previousPageUrl()}}"
                                onclick="{{$geideaHistories->onFirstPage()?" return false;":""}}"><i
                                    class="ft-arrow-left"></i> السابق</a>
                        </li>


                        <li class="{{$geideaHistories->hasMorePages()?'enabled':" disabled"}} ">
                                    <a href=" {{$geideaHistories->nextPageUrl()}}"
                            onclick="{{$geideaHistories->hasMorePages()?"":"return false;"}}" >التالى <i
                                class="ft-arrow-right"></i></a>
                        </li>


                    </ul>

                    @endif

                </div>


            </div>
        </div>
       
    </div>
</div>
@endsection