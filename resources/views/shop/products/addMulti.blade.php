@extends("shop.app")
@section("content")
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">

                <div class="card form-card" >
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">اضافه مجموعه منتجات</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include("alert.success")
                            @include("alert.error")
                            <form class="form" method="post" action="{{route("import.excel")}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-shopping-bag"></i> اضافه مجموعه من المنتجات</h4>
                                    <h5  style="font-size: 13px; color: grey;margin-bottom: 20px">يمكنك اضافه مجموعه من المنتجات دفعة واحده عن طريق رفع ملف excel بالمنتجات المراد اضافتها مع مراعاه شكل الملف المتفق عليه مع الادراه</h5>
                                    <div class="form-group">
                                        <label>برجاء اختيار ملف المنتجات (excel فقط)</label>
                                        <label  class="file center-block">
                                            <input type="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="file" class="form-control @error("file")is-invalid @enderror">
                                            <span class="file-custom"></span>
                                            @error('file')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </label>
                                    </div>

                                </div>






                                <div class="form-actions">
                                    <a  href="{{route("shop.home")}}" type="button"  class="btn btn-warning mr-1"  style="color: white">
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
