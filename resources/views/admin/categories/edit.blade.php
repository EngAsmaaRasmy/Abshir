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
                        <h4 class="card-title" id="basic-layout-form">تعديل قسم</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include('alert.success')
                            @include('alert.error')
                            <form class="form" method="post" action="{{ route('category.update', $category->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-grid"></i> معلومات القسم</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">اسم القسم عربى</label>
                                                <input value="{{ $category->name_ar }}" type="text" id="projectinput1"
                                                    class="form-control @error('name-ar') is-invalid @enderror"
                                                    placeholder="اسم القسم عربى" name="name-ar">
                                                @error('name-ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2">اسم القسم انجليزى</label>
                                                <input value="{{ $category->name_en }}" type="text" id="projectinput2"
                                                    class="form-control @error('name-en') is-invalid @enderror"
                                                    placeholder="اسم القسم انجليزى" name="name-en">
                                                @error('name-en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>


                                    <h4 class="form-section"><i class="la la-paperclip"></i> ايقونه القسم</h4>


                                    <div class="form-group">
                                        <label>برجاء اختيار ايقونة القسم عربى</label>
                                        <label class="file center-block">
                                            <input type="file" name="file"
                                                class="form-control @error('file') is-invalid @enderror">
                                            <span class="file-custom"></span>
                                            @error('file')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label>برجاء اختيار ايقونة انجيليزى</label>
                                        <label class="file center-block">
                                            <input type="file" name="file_en"
                                                class="form-control @error('file_en') is-invalid @enderror">
                                            <span class="file-custom"></span>
                                            @error('file_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </label>
                                    </div>

                                    <h4 class="form-section"><i class="la la-paperclip"></i>  ايقونه القسم  في الوضع المظلم</h4>

                                    <div class="form-group">
                                        <label>  برجاء اختيار ايقونة القسم العربي  في الوضع المظلم</label>
                                        <label class="file center-block">
                                            <input type="file" name="dark"
                                                class="form-control @error('dark') is-invalid @enderror">
                                            <span class="file-custom"></span>
                                            @error('dark')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        <label> برجاء اختيار ايقونة القسم إنجليزي  في الوضع المظلم</label>
                                        <label class="file center-block">
                                            <input type="file" name="dark_en"
                                                class="form-control @error('dark_en') is-invalid @enderror">
                                            <span class="file-custom"></span>
                                            @error('dark_en')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </label>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="projectinput2"> الحاله </label>
                                            <select name="active" class="select2 form-control">
                                                <optgroup label="من فضلك أختر حاله القسم ">
                                                    <option value="1"
                                                        @if ($category->active == 1) selected @endif>مفعل</option>
                                                    <option value="0"@if ($category->active == 0) selected @endif>
                                                        غير مفعل</option>
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
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
