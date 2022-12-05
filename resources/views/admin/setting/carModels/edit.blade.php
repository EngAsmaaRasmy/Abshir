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
                        <h4 class="card-title" id="basic-layout-form">تعديل الموديل</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include("alert.success")
                            @include("alert.error")
                            <form class="form" method="post" action="{{route("carModels.update",$car_model->id)}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-grid"></i> معلومات الموديل</h4>
                                    <input type="hidden" name="id" value="{{$car_model->id  }}"/>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">اسم الموديل</label>
                                                <input value="{{$car_model->model}}" type="text" id="projectinput1" class="form-control @error("model") is-invalid @enderror"
                                                       placeholder="اسم لماركه" name="model">
                                                @error('model')
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
                                                <label for="projectinput2"> الماركة </label>
                                                <select name="marker_id" class="select2 form-control">
                                                    <optgroup  label="من فضلك اختر الماركة " va>
                                                        @foreach($markers as $marker){
                                                        <option @if($car_model->marker_id == $marker->id) selected @endif value="{{$marker->id}}">{{$marker->marker}}</option>

                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                @error('marker')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label>برجاء صوره الماركه</label>
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


                                </div>

                                <div class="form-actions">
                                    <a  href="{{route("carModels.index")}}" type="button"  class="btn btn-warning mr-1"  style="color: white">
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
