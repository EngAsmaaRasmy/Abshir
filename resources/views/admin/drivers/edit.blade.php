@extends('admin.app')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">

                <div class="card form-card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">تعديل بيانات سائق</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include('alert.success')
                            @include('alert.error')
                            <form class="form" method="post" action="{{ route('driver.update', $driver->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="fa fa-motorcycle"></i> معلومات السائق</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">الاسم</label>
                                                <input value="{{ $driver->fullname }}" type="text" id="projectinput1"
                                                    class="form-control @error('fullname') is-invalid @enderror"
                                                    placeholder="اسم السائق بالكامل " name="fullname">
                                                @error('fullname')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2">رقم الهاتف</label>
                                                <input value="{{ $driver->phone }}" type="text" id="projectinput2"
                                                    class="form-control @error('phone') is-invalid @enderror"
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
                                                <input value="{{ $driver->username }}" type="text" id="projectinput1"
                                                    class="form-control @error('address') is-invalid @enderror"
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
                                                <input type="password" id="projectinput1"
                                                    class="form-control @error('address') is-invalid @enderror"
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
                                                <label for="projectinput1">العنوان</label>
                                                <input value="{{ $driver->address }}" type="text" id="projectinput1"
                                                    class="form-control @error('address') is-invalid @enderror"
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
                                                <select name="active" class="select2 form-control">
                                                    <optgroup label="من فضلك أختر حاله السائق ">
                                                        <option value="1">مفعل</option>
                                                        <option value="0">غير مفعل</option>
                                                    </optgroup>
                                                </select>
                                                @error('active')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <a href="{{ route('admin.home') }}" type="button" class="btn btn-warning mr-1"
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
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
