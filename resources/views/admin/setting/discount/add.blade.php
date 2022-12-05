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
                                <h4 class="card-title" id="basic-layout-form">اضافة خصم جديد</h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    @include("alert.success")
                                    @include("alert.error")
                                    <form class="form" method="post" action="{{route("discountSettings.save")}}"  enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2"> نوع الخصم </label>
                                                        <select name="name" class="select2 form-control">
                                                            <optgroup label="من فضلك أختر نوع الخصم ">
                                                                <option value="driver">سائق</option>
                                                                <option value="customer">عميل</option>
                                                            </optgroup>
                                                        </select>
                                                        @error('name')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="discountValue">  قيمة الخصم </label>
                                                        <input type="text" class="form-control @error("discount_value") is-invalid @enderror"
                                                        placeholder=" قيمة الخصم   " name="discount_value" required>
                                                        @error('discount_value')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
        
        
                                        <div class="form-actions">
                                            <a  href="{{route("discountSettings.index")}}" type="button"  class="btn btn-warning mr-1"  style="color: white">
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





