@extends('admin.app')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
           
            <div class="content-body">
                <div class="row my-auto">
                    <div class="col-lg-8 col-md-8 m-auto"> 
                        <div class="card">
                            <div class="card-body">
                                @include('alert.success')
                                @include('alert.error')
                                <form method="post" enctype="multipart/form-data" action="{{ route('chat')}}">
                                    @csrf
                                    <div class="pd-30 pd-sm-40 bg-gray-200">
                                        <div class="row align-items-center mg-b-20">
                                            <div class="col-md-9">
                                                <input type="hidden" name="type" value="driver">
                                                <input required class="form-control" placeholder="أدخل رقم الهاتف" id="phone"
                                                    name="phone" type="text">
                                            </div>
                
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-search"></i>بحث</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
@endsection
