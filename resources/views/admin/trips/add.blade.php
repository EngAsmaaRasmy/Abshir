@extends("admin.app2")
@section("content")
<div class="modal fade" id="customer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">إضافة عميل جديد </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body ">
          <form  method="post" role="form">
            {{ csrf_field() }}
            <div class="">
              <div class="card">
                <div class="card-body">
                  <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                  <input type="hidden" id="clientId"  name="client_id" value="{{isset($customer->id) ? $customer->id+1 : 1}}">
                  <div class="form-group">
                    <label>اسم العميل</label>
                    <input type="text" class="form-control" id="clientName" required name="name">
                  </div>
                  <div class="form-group">
                    <label>رقم هاتف العميل</label>
                    <input type="text" class="form-control" id="clientPhone" required name="phone">
                  </div>
                </div>
              </div>
              <div class="modal-footer d-block">
                <button type="button" id="addClint" class="btn btn-warning float-right">حقظ</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="app-content content">
  <div class="content-overlay"></div>
  <div class="content-wrapper ">
    <div class="content-header row">
    </div>
    <div class="content-body">

      <div class="card form-card">
        <div class="card-header">
          <h4 class="card-title" id="basic-layout-form">اضافه رحلة جديدة</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-content collapse show">
          <div class="card-body">
            @include("alert.success")
            @include("alert.error")
            <form class="form" method="post" action="{{route("trip.save")}}" enctype="multipart/form-data">
              @csrf
              <div class="mb-2">
                <input
                id="end-input"
                class="controls"
                type="text"
                placeholder="نقطة النهاية"
              />
                <input
                  id="start-input"
                  class="controls"
                  type="text"
                  placeholder="نقطة البداية"
                />
              </div>
              <div id="map" style="width:100%;height:600px; padding-bottom: 20px;"></div>
              <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
              <input type="hidden" name="price_list_id" id="price_list_id" value="1" />
              <input type="hidden" name="start_lat" id="start_lat"/>
              <input type="hidden" name="start_long" id="start_long"/>
              <input type="hidden" name="end_lat" id="end_lat" />
              <input type="hidden" name="end_long" id="end_long" />
              <br>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="projectinput3"> العميل </label>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#customer">+
                      إضافة عميل جديد</button>
                    <br><br>
                    <select id="clint" name="clint_id" class="select2 form-control" required>
                      <option value="من فضلك اخترالعميل" selected>من فضلك اختر العميل</option>
                      @foreach($customers as $customer){
                      <option value={{$customer->id}}>{{$customer->phone}} {{ $customer->name }}</option>
                      }
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="form-actions">
                <a href="{{route("trips.index")}}" type="button" class="btn btn-warning mr-1" style="color: white">
                  <i class="ft-x"></i> الغاء
                </a>
                <button id="addTrip" type="button" class="btn btn-primary">
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
<style>
  .controls {
  background-color: #fff;
  border-radius: 2px;
  border: 1px solid transparent;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
  box-sizing: border-box;
  font-family: Roboto;
  font-size: 15px;
  font-weight: 300;
  height: 29px;
  margin-left: 17px;
  margin-top: 10px;
  outline: none;
  padding: 0 15px 0 18px;
  text-overflow: ellipsis;
  width: 300px;
}

.controls:focus {
  border-color: #6197ec;
}



</style>
@endsection
