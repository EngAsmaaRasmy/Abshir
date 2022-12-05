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
                        <h4 class="card-title" id="basic-layout-form">تعديل الملف الشخصى</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include("alert.success")
                            @include("alert.error")
                            <form class="form" method="post" action="{{route("admin.profile.edit")}}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-shopping-bag"></i> المعلومات الشخصيه</h4>
                                    <div class="row">


                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="projectinput1">البريد الاليكترونى</label>
                                                    <input type="text" id="projectinput1" value="{{$user->email}}"
                                                           class="form-control @error("email") is-invalid @enderror"
                                                           placeholder="تعديل البريد الاليكترونى" name="email">
                                                    @error('email')
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
