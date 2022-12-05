@extends("shop.app")
@section("content")
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div  class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">

                <div class="card form-card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">تعديل الملف الشخصى</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include("alert.success")
                            @include("alert.error")
                            <form class="form" method="post" action="{{route("shop.profile.edit")}} "
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-shopping-bag"></i> المعلومات الشخصيه</h4>
                                    <div class="row">


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="projectinput1">اسم المستخدم</label>
                                                    <input type="text" id="projectinput1" value="{{$user->username}}"
                                                           class="form-control @error("username") is-invalid @enderror"
                                                           placeholder="تعديل البريد الاليكترونى" name="username">
                                                    @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">كلمة السر القديمة</label>
                                                <input type="password" id="projectinput1"
                                                       class="form-control @error("oldPassword") is-invalid @enderror"
                                                       placeholder="كلمة السر القديمة" name="oldPassword">
                                                @error('oldPassword')
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
                                                <label for="projectinput2"> كلمه السر الجديدة</label>
                                                <input type="password" id="projectinput2"
                                                       class="form-control @error("password") is-invalid @enderror"
                                                       placeholder="كلمه السر الجديدة" name="password">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">تاكيد كلمه السر الجديدة</label>
                                                <input type="password" id="projectinput1"
                                                       class="form-control @error("confirmPassword") is-invalid @enderror"
                                                       placeholder="تاكيد كلمه السر الجديدة" name="confirmPassword">
                                                @error('confirmPassword')
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
                                                <label for="projectinput1">اسم المحل</label>
                                                <input type="text" id="projectinput1" value="{{$user->name}}"
                                                       class="form-control @error("name") is-invalid @enderror"
                                                       placeholder="اسم المحل" name="name">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">رقم الهاتف</label>
                                                <input type="text" id="projectinput1" value="{{$user->phone}}"
                                                       class="form-control @error("phone") is-invalid @enderror"
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
                                                <label for="open">ميعاد فتح المحل</label>
                                                <div class="position-relative has-icon-left">
                                                    <input value="{{$user->open_at}}" type="time" id="open" class="form-control" name="open_at">
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
                                                    <input value="{{$user->close_at}}" type="time" id="close" class="form-control" name="close_at">
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
                                                <input type="text" id="projectinput1" value="{{$user->address}}"
                                                       class="form-control @error("address") is-invalid @enderror"
                                                       placeholder="تغيير عنوان المحل" name="address">
                                                @error('address')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">متوسط وقت تجهيز الطلب</label>
                                                <input type="text" id="projectinput1" value="{{$user->prepare_time}}"
                                                       class="form-control @error("prepare_time") is-invalid @enderror"
                                                       placeholder="تغيير عنوان المحل" name="prepare_time">
                                                @error('prepare_time')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>



                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput1">تكلفه التوصيل</label>
                                            <input type="text" id="projectinput1" value="{{$user->delivery_cost}}"
                                                   class="form-control @error("delivery_cost") is-invalid @enderror"
                                                   placeholder="تغيير تكلفة التوصيل" name="delivery_cost">
                                            @error('delivery_cost')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <h4 class="form-section"><i class="la la-paperclip"></i> لوجو المحل</h4>


                                <div class="form-group">
                                    <label>تغيير لوجو المحل</label>
                                    <label  class="file center-block">
                                        <input type="file" name="logo" class="form-control @error("logo")is-invalid @enderror">
                                        <span class="file-custom"></span>
                                        @error('logo')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </label>
                                </div>

                                <div class="form-actions">
                                    <a href="{{route("admin.home")}}" type="button" class="btn btn-warning mr-1"
                                       style="color: white">
                                        <i class="ft-x"></i> الغاء
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> تعديل
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
