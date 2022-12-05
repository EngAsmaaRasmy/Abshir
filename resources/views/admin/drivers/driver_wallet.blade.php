@extends("admin.app")
@section("content")
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="content-wrapper ">
        <div class="content-header row">
        </div>
        <div class="content-body">

            <div class="card form-card">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-form">تعديل محفظة السائق</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        @include("alert.success")
                        @include("alert.error")
                        <form class="form" method="post" action="{{route("driver.wallet.update")}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <h4 class="form-section"><i class="fa fa-motorcycle"></i> معلومات المحفظه</h4>
                                <input type="hidden" name="wallet_id" value="{{ $wallet->id }}"/>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput1">الرصيد</label>
                                            <input value="{{$wallet->wallet_balance}}" type="text" id="projectinput1"
                                                class="form-control @error(" wallet_balance") is-invalid @enderror"
                                                placeholder="الرصيد " name="wallet_balance" readonly>
                                            @error('wallet_balance')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput1">القيمه</label>
                                            <input type="text" id="projectinput1"
                                                class="form-control @error(" value") is-invalid @enderror"
                                                placeholder="القيمه " name="value" >
                                            @error('value')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="projectinput2"> نوع القيمه </label>
                                            <select name="type" class="select2 form-control">
                                                <optgroup label="من فضلك اختر نوع القيمه ">
                                                    
                                                    <option value="Add">إضافة</option>
                                                    <option value="Minus" selected>خصم</option>
    
                                                   
                                                </optgroup>
                                            </select>
                                            @error('type')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <a href="{{url()->previous()}}" type="button" class="btn btn-warning mr-1"
                                        style="color: white">
                                        <i class="ft-x"></i> الغاء
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> حفظ
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div>
                        <table>
                            <div class="table-responsive-sm">
                                <table class="table">
                                    <thead class="bg-primary white">
                                    <tr>
                                        <th>#</th>
                                        <th>القيمه</th>
                                        <th>النوع</th>
                                        <th>نوع الاضافه</th>
                                        <th> بواسطة</th>
                                        <th> تاريخ الاضافه</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @isset($wallet_history)
                                        @foreach($wallet_history as $wallet)
                                            <tr>
                                                <th scope="row">{{$wallet->id}}</th>
                                                <td>{{$wallet->value}}</td>
                                                <td>@if($wallet->type == "Add") إضافه@else خصم@endif</td>
                                                <td>@if($wallet->user_type == "Admin")أدمن @else عميل @endif</td>
                                                <td>
                                                    @if($wallet->user_type == "Admin")
                                                        {{ $wallet->adminName }}
                                                    @else
                                                        {{ $wallet->customerName }}
                                                    @endif

                                                </td>
                                                <td>{{ $wallet->created_at }}</td>
                                            
    
                                            </tr>
    
                                        @endforeach
                                    @endisset
    
                                    </tbody>
                                </table>
                                @if($wallet_history->hasPages())
                                <ul class="pager pager-flat">
    
                                    <li class="{{$wallet_history->onFirstPage()?'disabled':"enabled"}}">
                                        <a href="{{$wallet_history->previousPageUrl()}}"  onclick="{{$wallet_history->onFirstPage()?"return false;":""}}" ><i class="ft-arrow-left"></i> السابق</a>
                                    </li>
    
    
                                    <li class="{{$wallet_history->hasMorePages()?'enabled':"disabled"}} ">
                                        <a href="{{$wallet_history->nextPageUrl()}}" onclick="{{$wallet_history->hasMorePages()?"":"return false;"}}" >التالى <i class="ft-arrow-right"></i></a>
                                    </li>
    
    
                                </ul>
    
                                    @endif
    
                            </div>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection