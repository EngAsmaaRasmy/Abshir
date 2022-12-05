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
                        <h4 class="card-title" id="basic-layout-form">ارسال اشعار للمحلات </h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include("alert.success")
                            @include("alert.error")
                            <form class="form" method="post" action="{{route("send.shop.notification")}}">
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="fa fa-bell-o"></i> تفاصيل الاشعار</h4>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">العنوان</label>
                                                <input type="text" id="projectinput1"
                                                       class="form-control @error("title") is-invalid @enderror"
                                                       placeholder="عنوان الاشعار" name="title">
                                                @error('title')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2">التفاصيل</label>
                                                <input type="text" id="projectinput2"
                                                       class="form-control @error("content") is-invalid @enderror"
                                                       placeholder="محتوى الاشعار" name="content">
                                                @error('content')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    @isset($shops)

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <select name="shop" class="selectpicker form-control ">
                                                 @foreach($shops as $shop)
                                                 <option  value="{{$shop->id}}">{{$shop->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    @endisset
                                    <div class="form-actions">
                                        <a href="{{route("admin.home")}}" type="button" class="btn btn-warning mr-1"
                                           style="color: white">
                                            <i class="ft-x"></i> الغاء
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i>ارسال
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
