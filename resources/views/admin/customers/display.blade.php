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
                        <p style="font-weight: bold; font-size: 18px">العملاء</p>
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
                                    <th>رقم الهاتف</th>
                                    <th>رصيد المحفظة</th>
                                    <th>الحالة</th>
                                    <th>الاجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($customers)
                                @foreach($customers as $customer)
                                <tr>
                                    <th scope="row">{{$customer->id}}</th>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$customer->phone}}</td>
                                    <td>{{$customer->wallet_balance}}</td>
                                    <td class="text-center"><span
                                            class="@if($customer->active==1)text-success @else text-danger @endif">{{$customer->active==1?"مفعل":"غير
                                            مفعل"}}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{route("customer.toggle_active",$customer->id)}}"
                                                class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1
                                                mb-1">{{$customer->active==1?"الغاء التفعيل":"تفعيل"}}</a>
                                            <a href="{{route("customer.wallet",$customer->id)}}"
                                                class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1
                                                mb-1">المحفظة</a>

                                        </div>
                                    </td>


                                </tr>

                                @endforeach
                                @endisset

                            </tbody>
                        </table>
                        @if($customers->hasPages())
                        <ul class="pager pager-flat">

                            <li class="{{$customers->onFirstPage()?'disabled':" enabled"}}">
                                <a href="{{$customers->previousPageUrl()}}" onclick="{{$customers->onFirstPage()?"
                                    return false;":""}}"><i class="ft-arrow-left"></i> السابق</a>
                            </li>


                            <li class="{{$customers->hasMorePages()?'enabled':" disabled"}} ">
                                    <a href=" {{$customers->nextPageUrl()}}"
                                onclick="{{$customers->hasMorePages()?"":"return false;"}}" >التالى <i
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