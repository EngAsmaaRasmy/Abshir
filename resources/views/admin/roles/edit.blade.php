@extends("admin.app")
@section("content")
<div class="modal fade" id="permission" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">إضافة إذن جديد </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body ">
          <form action="{{ route('add.permission') }}" method="post" role="form">
            {{ csrf_field() }}
            <div class="">
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <label>الإذن</label>
                    <input type="text" class="form-control" required name="name">
                  </div>
                </div>
              </div>
              <div class="modal-footer d-block">
                <button type="submit" class="btn btn-warning float-right" id="btnSave">حقظ</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">

                <div class="card form-card" >
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">تعديل صلاحية</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include("alert.success")
                            @include("alert.error")
                            <form class="form" method="post" action="{{route("role.update",$role->id)}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="ft-grid"></i> معلومات الصلاحية</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">الاسم  </label>
                                                <input type="text" id="projectinput1" class="form-control @error("name") is-invalid @enderror"
                                                       placeholder="الاسم  " name="name" value="{{$role->name}}">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>


                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label>الاذونات:</label>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#permission">+
                                            إضافة إذن جديد</button>
                                        <br/><br>
                                        <input type="checkbox" name="select-all" id="select-all" value="تحديد الكل"/>
                                        <label for="select-all">تحديد الكٌل</label>
                                        <br>
                                        <br>
                                        @foreach($permission as $value)
                                            <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                            <span style="font-size: 17px">{{ $value->name }}</span></label>
                                        <br/>
                                        @endforeach
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
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
