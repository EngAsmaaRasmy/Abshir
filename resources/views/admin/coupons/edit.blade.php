@extends("admin.app")
@section("content")
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">

                <div class="card form-card" >
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">تعديل كوبون</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include("alert.success")
                            @include("alert.error")
                            <form class="form" method="post" action="{{route("coupon.update",$coupon->id)}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-grid"></i> معلومات الكوبون</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">الكود</label>
                                                <input type="text" id="projectinput1"
                                                       class="form-control @error("name") is-invalid @enderror"
                                                       placeholder="الكود" name="name" value="{{$coupon->name}}">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="type"> النوع </label>
                                                <select id="type" name="type" class="select2 form-control">
                                                    <optgroup label="من فضلك أختر نوع الخسم ">
                                                        @foreach($couponTypes as $type){
                                                        <option @if($coupon->type==$type->id) selected @endif value={{$type->id}} >{{$type->name}}</option>
                                                        }
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                @error('type')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">النسبة</label>
                                                <input type="text" id="projectinput1"
                                                       class="form-control @error("percentage") is-invalid @enderror"
                                                       placeholder="نسبة الخصم" name="percentage" value="{{$coupon->percentage}}">
                                                @error('percentage')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">المبلغ</label>
                                                <input type="text" id="projectinput1"
                                                       class="form-control @error("value") is-invalid @enderror"
                                                       placeholder="مبلغ الخصم" name="value" value="{{$coupon->value}}">
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
                                                <label for="projectinput1">العدد المسموح</label>
                                                <input type="text" id="projectinput1"
                                                       class="form-control @error("max_count") is-invalid @enderror"
                                                       placeholder="العدد المسموح" name="max_count" value="{{$coupon->max_count}}">
                                                @error('max_count')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="offer_expireDate">تاريخ انتهاء العرض</label>
                                                <input value="{{$coupon->expire_date}}" type="date" id="offer_expireDate" class="form-control" name="expire_date" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Fixed" data-original-title="" title="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">الحد الادنى للطلب</label>
                                                <input type="text" id="projectinput1"
                                                       class="form-control @error("minimum_order") is-invalid @enderror"
                                                       placeholder="الحد الادنى للطلب" name="minimum_order" value="{{$coupon->minimum_order}}">
                                                @error('minimum_order')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="shop">المحل </label>
                                                <select id="shop" name="shop" class="select2 form-control">
                                                    <optgroup label="من فضلك أختر المحل ">
                                                        <option value="{{-1}}">على كل المحلات</option>
                                                        @foreach($shops as $shop){
                                                        <option @if($shop->id==$coupon->shop) selected @endif value={{$shop->id}}>{{$shop->name}}</option>
                                                        }
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                @error('driver_id')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-actions">
                                    <a  href="{{route("admin.home")}}" type="button"  class="btn btn-warning mr-1"  style="color: white">
                                        <i class="ft-x"></i> الغاء
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> حفظ
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
