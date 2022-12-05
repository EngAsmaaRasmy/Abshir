@extends("admin.app2")
@section("content")
   <div class="app-content content ">
                <div class="content-overlay"></div>
                <div class="content-wrapper ">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
        
                        <div class="card form-card" >
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-form">تعديل الماركة</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    @include("alert.success")
                                    @include("alert.error")
                                    <div class="alert alert-success" role="alert" id="successMsg" style="display: none" >
                                        تم تعديل قائمة الاسعار  بنجاح 
                                    </div>
                                    <div class="alert alert-danger" role="alert" id="errorMsg" style="display: none" >
                                    </div>
                                    <form class="form" method="post" action="{{route("priceLists.update",$priceList->id)}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-grid"></i> معلومات الماركه</h4>
                                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="id" id="vehicleId"  value="{{$priceList->id}}"/>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="vehicleName">اسم نوع السيارة</label>
                                                        <input type="text" id="vehicleName" class="form-control @error("name") is-invalid @enderror"
                                                               placeholder="اسم نوع السيارة " name="name" required value="{{$priceList->name}}">
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="kiloPrice">  سعر الكيلو</label>
                                                        <input type="text" id="kiloPrice" class="form-control @error("kilo_price") is-invalid @enderror"
                                                               placeholder=" سعر الكيلو  " name="kilo_price" required value="{{$priceList->kilo_price}}">
                                                        @error('kilo_price')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="minutePrice">  سعر الدقيقة</label>
                                                        <input type="text" id="minutePrice" class="form-control @error("minute_price") is-invalid @enderror"
                                                               placeholder=" سعر الدقيقة  " name="minute_price" required value="{{$priceList->minute_price}}">
                                                        @error('minute_price')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="startPrice">  سعر بداية التحرك</label>
                                                        <input type="text" id="startPrice" class="form-control @error("start_price") is-invalid @enderror"
                                                               placeholder="  سعر بداية التحرك " name="start_price" required value="{{$priceList->start_price}}">
                                                        @error('start_price')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                               
                                            </div>
        
                                        </div>
        
                                        <div class="form-actions">
                                            <a  href="{{route("priceLists.index")}}" type="button"  class="btn btn-warning mr-1"  style="color: white">
                                                <i class="ft-x"></i> الغاء
                                            </a>
                                            <button id="updateBtn" type="button"  class="btn btn-primary">
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





