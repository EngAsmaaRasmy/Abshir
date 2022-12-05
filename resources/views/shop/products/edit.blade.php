@extends('shop.app')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">

                <div class="card form-card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">تعديل المنتج</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include('alert.success')
                            @include('alert.error')
                            <form class="form" method="post" action="{{ route('update.product', $product->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-shopping-bag"></i> معلومات المنتج</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">اسم المنتج عربى</label>
                                                <input type="text" id="projectinput1"
                                                    class="form-control @error('name_ar') is-invalid @enderror"
                                                    placeholder="اسم المنتج عربى" name="name_ar"
                                                    value="{{ $product->name_ar }}">
                                                @error('name_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2">اسم المتنج انجليزى</label>
                                                <input type="text" id="projectinput2"
                                                    class="form-control @error('name_en') is-invalid @enderror"
                                                    placeholder="اسم المنتج انجليزى" name="name_en"
                                                    value="{{ $product->name_en }}">
                                                @error('name_en')
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
                                                <label for="projectinput2"> القسم </label>
                                                <select name="category" class="select2 form-control">
                                                    <optgroup label="من فضلك اختر القسم " va>
                                                        @foreach ($categories as $category)
                                                            {
                                                            <option @if ($category->id == $product->category) selected @endif
                                                                value="{{ $category->id }}">{{ $category->name_ar }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                @error('category')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="description_ar">وصف المنتج عربى</label>
                                                <input value="{{ $product->description_ar }}" id="description_ar"
                                                    rows="5"
                                                    class="form-control @error('description_ar') is-invalid @enderror"
                                                    name="description_ar" placeholder="برجاء ادخال وصف المنتج عربى ">
                                                @error('description_ar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="description_en">وصف المنتج انجليزى(اختيارى)</label>
                                                <input value="{{ $product->description_en }}" id="description_en"
                                                    rows="5" class="form-control" name="description_en"
                                                    placeholder="برجاء ادخال وصف المنتج انجليزى">
                                                @error('description_en')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="form-section"><i class="ft-shopping-bag"></i> احجام المنتج</h4>


                                    <div class="table-responsive-lg">
                                        <table class="table fixed">
                                            <thead class="bg-primary white">
                                                <tr>

                                                    <th>الحجم</th>
                                                    <th>السعر</th>
                                                    <th>الاجراءات</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($sizes as $size)
                                                    <tr>


                                                        <td>{{ $size->name }}</td>
                                                        <td>{{ $size->price }}</td>


                                                        <td>
                                                            <div class="btn-group" role="group"
                                                                aria-label="Basic example">
                                                                <a href="{{ route('edit.size', $size->id) }}"
                                                                    class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                                <a href="{{ route('delete.size', $size->id) }}"
                                                                    class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>

                                                            </div>
                                                        </td>


                                                    </tr>
                                                @endforeach


                                            </tbody>
                                        </table>
                                    </div>

                                    <h4 class="form-section"><i class="ft-shopping-bag"></i>اضافه احجام جديدة</h4>
                                    <sizes-component></sizes-component>

                                    <div class="form-group">
                                        <label>برجاء اختيار صوره المنتج</label>
                                        <label class="file center-block">
                                            <input value="{{ $product->image }}" type="file" name="file"
                                                class="form-control @error('file') is-invalid @enderror">
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
                                    <a href="{{ route('shop.home') }}" type="button" class="btn btn-warning mr-1"
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
