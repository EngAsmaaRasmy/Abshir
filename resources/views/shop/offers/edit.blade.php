@extends("shop.app")
@section("content")
    <div onload="" class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">

                <div class="card form-card" >
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">تعديل عرض</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include("alert.success")
                            @include("alert.error")
                            <form class="form" method="post" action="{{route("update.shop.offer",$offer->id)}}" >
                                @csrf
                                <div class="form-body">
                                    <h4 class="form-section"><i class="fa fa-bullhorn"></i> معلومات العرض</h4>

                                  <div >
                                  <offer-component :offer="'{{$offer}}'" :types="'{{$offersType}}'"></offer-component>
                                  </div>

                                    </div>


                                <div class="form-actions" >
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
