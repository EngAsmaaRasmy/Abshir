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
                        <h4 class="card-title" id="basic-layout-form">  إضافة تعليق</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include("alert.success")
                            @include("alert.error")
                            <form class="form" method="post" action="{{route("updateComment",$driver->id)}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="fa fa-motorcycle"></i> إضافة تعليق</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="projectinput1">التعليق :</label>
                                                <textarea rows="20" value="{{ $driver->comment }}" type="text" id="projectinput1"
                                                    class="form-control @error('comment') is-invalid @enderror"
                                                    name="comment">{{ $driver->comment }}</textarea>
                                                @error('comment')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
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
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
