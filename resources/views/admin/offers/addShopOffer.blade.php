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
                        <h4 class="card-title" id="basic-layout-form">اضافه عرض جديد</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include("alert.success")
                            @include("alert.error")
                            <form class="form" method="post" action="{{route("shop.offer.save")}}" enctype="multipart/form-data" >
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="fa fa-bullhorn"></i> معلومات العرض</h4>

                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="projectinput1">المده</label>
                                                <input type="text" id="projectinput1" class="form-control @error("fullname") is-invalid @enderror"
                                                       placeholder="مده استمرار العرض" name="duration">
                                                @error('duration')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2"> القسم </label>
                                                <select name="category" class="select2 form-control">
                                                    <optgroup label="من فضلك اختر القسم">
                                                        @foreach(\App\Models\admin\CategoryModel::all() as $category){
                                                        <option value={{$category->id}}>{{$category->name_ar}}</option>
                                                        }
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                @error('category')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>برجاء صوره العرض</label>
                                        <label  class="file center-block">
                                            <input type="file" name="image" class="form-control @error("image")is-invalid @enderror">
                                            <span class="file-custom"></span>
                                            @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </label>
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
@endsection
