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
                            <form class="form" method="post" action="{{route("export.products")}}">
                                @csrf
                                <div class="form-body"  >
                                    <h4 class="form-section"><i class="ft-shopping-bag"></i> تصدير المنتجات</h4>
                                    <h5  style="font-size: 13px; color: grey;margin-bottom: 20px">قم باختيار القسم المراد تصدير منتجاته</h5>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2"> القسم </label>
                                                <select name="category" class="select2 form-control">
                                                    <optgroup label="من فضلك اختر القسم ">
                                                        @foreach($categories as $category){
                                                        <option value="{{$category->id}}">{{$category->name_ar}}</option>

                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                @error('category')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>
                                        </div>
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
