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
                                <h4 class="card-title" id="basic-layout-form">عرض تفاصيل الرحلة</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    @include("alert.success")
                                    @include("alert.error")
                                    <div class="form-body">
                                        <div class="row">
                                            @isset($trip->customerRel->name)
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label"><b>اسم العميل  : </b></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$trip->customerRel->name ?? " "}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            @endisset
                                            @isset($trip->driverRel->fullname)
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label"><b>اسم السائق : </b></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$trip->driverRel->fullname ?? " "}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            @endisset
                                        </div>
                                        <div class="row">
                                            @isset($trip->driverRel->phone)
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label"><b>رقم  السائق : </b></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$trip->driverRel->phone ?? ""}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            @endisset
                                            @isset($trip->priceList->name)
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label"><b>نوع الرحلة : </b></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$trip->priceList->name ?? ""}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            @endisset
                                            @isset($trip->created_at)
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label"><b>وقت  إنشاء الرحلة  : </b></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$trip->created_at?? ""}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            @endisset
                                            @isset($trip->trip_approve_time) 
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label"><b> وقت الموافقة علي الرحلة: </b></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$trip->trip_approve_time ?? ""}}" />
                                                    </div>
                                                </div>
                                            </div> 
                                            @endisset
                                            @isset($trip->trip_arrive_time) 
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label"><b> وقت وصول السائق: </b></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$trip->trip_arrive_time ?? ""}}" />
                                                    </div>
                                                </div>
                                            </div> 
                                            @endisset
                                            @isset($trip->trip_start_time) 
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label"><b> وقت بداية الرحلة  : </b></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$trip->trip_start_time ?? ""}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            @endisset
                                            @isset($trip->trip_end_time)    
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label"><b>وقت إنتهاء  الرحلة : </b></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$trip->trip_end_time ?? ""}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            @endisset
                                            @isset($trip->distance) 
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label"><b>المسافة : </b></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$trip->distance ?? ""}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            @endisset
                                            @isset($trip->cost)    
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label"><b>   التكلفة: </b></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$trip->cost ?? ""}}" />
                                                    </div>
                                                </div>
                                            </div>
                                            @endisset
                                            @isset($trip->cancellation_reason) 
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-2 col-form-label"><b>   سبب إلغاء الرحلة: </b></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="{{$trip->cancellation_reason ?? ""}}" />
                                                    </div>
                                                </div>
                                            </div>                 
                                            @endisset   
                                        </div>
                                     
                                      
                                    </div>
                                </div>
                            </div>
                        </div>
        
                    </div>
                </div>
            </div>
@endsection





