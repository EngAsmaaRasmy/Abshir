<html class="loaded" lang="en" data-textdirection="rtl" style="font-family:'Almarai', sans-serif;"><!-- BEGIN: Head-->
<head>

@include("admin.layout.head")

<body class="vertical-layout vertical-menu-modern 2-columns fixed-navbar  menu-expanded pace-done" data-open="click"
      data-menu="vertical-menu-modern" data-col="2-columns">
<div class="pace  pace-inactive">
    <div class="pace-progress" data-progress-text="100%" data-progress="99"
         style="transform: translate3d(100%, 0px, 0px); font-family: Almarai">
        <div class="pace-progress-inner"></div>
    </div>
    <div class="pace-activity"></div>
</div>

@include("admin.layout.header")




@include("admin.layout.sidebar")

<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="content-wrapper ">
        <div class="content-header row">
        </div>
        <div class="content-body">

            <div class="card form-card" >
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-form">تعديل بيانات سائق</h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                       @include("alert.success")
                        @include("alert.error")
                        <form class="form" method="post" action="{{route("shop.update",$shop->id)}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <h4 class="form-section"><i class="fa fa-motorcycle"></i> معلومات السائق</h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput1">الاسم</label>
                                            <input value="{{$shop->name}}" type="text" id="projectinput1" class="form-control @error("name") is-invalid @enderror"
                                                   placeholder= "اسم المحل"  name="name">
                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput2">رقم الهاتف</label>
                                            <input value="{{$shop->phone}}" type="text" id="projectinput2" class="form-control @error("phone") is-invalid @enderror"
                                                   placeholder="رقم الهاتف" name="phone">
                                            @error('phone')
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
                                            <label for="projectinput1">اسم المستخدم</label>
                                            <input value="{{$shop->username}}" type="text" id="projectinput1" class="form-control @error("address") is-invalid @enderror"
                                                   placeholder="اسم المستخدم" name="username">
                                            @error('username')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput1">كلمة السر</label>
                                            <input  type="password" id="projectinput1" class="form-control @error("address") is-invalid @enderror"
                                                   placeholder="كلمة السر" name="password">
                                            @error('password')
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
                                            <label for="open">ميعاد فتح المحل</label>
                                            <div class="position-relative has-icon-left">
                                                <input value="{{$shop->open_at}}" type="time" id="open" class="form-control" name="open_at">
                                                <div class="form-control-position">
                                                    <i class="ft-clock"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="close">ميعاد الغلق</label>
                                            <div class="position-relative has-icon-left">
                                                <input value="{{$shop->close_at}}" type="time" id="close" class="form-control" name="close_at">
                                                <div class="form-control-position">
                                                    <i class="ft-clock"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput1">العنوان</label>
                                            <input value="{{$shop->address}}" type="text" id="projectinput1" class="form-control @error("address") is-invalid @enderror"
                                                   placeholder="العنوان" name="address">
                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput2"> الحاله </label>
                                            <select  name="active" class="select2 form-control">
                                                <optgroup label="من فضلك أختر حاله المحل ">
                                                    <option value="1">مفعل</option>
                                                    <option value="0">غير مفعل</option>
                                                </optgroup>
                                            </select>
                                            @error('active')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput2"> القسم </label>
                                            <select name="category"  class="select2 form-control">
                                                <optgroup label="من فضلك القسم ">
                                                    @foreach(\App\Models\admin\CategoryModel::all() as $category)

                                                        <option @if($category->id==$shop->category) selected @endif value="{{$category->id}}">{{$category->name_ar}}</option>
                                                    @endforeach
                                                </optgroup>
                                            </select>
                                            @error('category')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<div>

    @include("admin.layout.footer")
</div>
<!-- BEGIN: Vendor JS-->
<script src="{{asset("app-assets/vendors/js/vendors.min.js")}}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{asset("app-assets/vendors/js/charts/chart.min.js")}}"></script>
<script src="{{asset("app-assets/vendors/js/charts/raphael-min.js")}}"></script>
<script src="{{asset("app-assets/vendors/js/charts/morris.min.js")}}"></script>
<script src="{{asset("app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js")}}"></script>
<script src="{{asset("app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js")}}"></script>
<script src="{{asset("app-assets/data/jvector/visitor-data.js")}}"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="../../../app-assets/js/core/app-menu.js"></script>
<script src="../../../app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="../../../app-assets/js/scripts/pages/dashboard-sales.js"></script>
<!-- END: Page JS-->


<!-- END: Body-->

<div class="jvectormap-tip"></div>
</body>
</html>
