@extends('admin.app2')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="content-wrapper ">
            <div class="content-header row">
            </div>
            <div class="content-body">

                <div class="card form-card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-form">تعديل تقاصيل المنتج</h4>
                        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            @include('alert.success')
                            @include('alert.error')
                            <form class="form" method="post"
                                action="{{ route('orderProduct.update', $orderProduct->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">المنتج</label>
                                                <select id="product" name="product" class="select2 form-control" required>
                                                    <option disabled value="من فضلك اختر المنتج" selected>من فضلك اختر
                                                        المنتج</option>
                                                    @foreach (\App\Models\shop\Product::where('shop', $order->shop)->get() as $product)
                                                        {
                                                        <option value={{ $product->id }}
                                                            {{ $orderProduct->product == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name_ar }}</option>
                                                        }
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput1">الحجم</label>
                                                <select id="product" name="size_id" class="select2 form-control" required>
                                                    <option disabled value="من فضلك اختر الحجم" selected>من فضلك اختر
                                                        الحجم</option>
                                                    @foreach (\App\Models\shop\SizePrice::where('product_id', $orderProduct->product)->get() as $size)
                                                        {
                                                        <option value={{ $size->id }}
                                                            {{ $orderProduct->size_id == $size->id ? 'selected' : '' }}>
                                                            {{ $size->name }}</option>
                                                        }
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2">الكمية</label>
                                                <input type="text" id="projectinput2"
                                                    class="form-control @error('amount') is-invalid @enderror"
                                                    placeholder="الكمية" name="amount" value="{{ $orderProduct->amount }}">
                                                @error('amount')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="projectinput2">السعر</label>
                                                <input type="text" id="projectinput2"
                                                    class="form-control @error('amount') is-invalid @enderror"
                                                    placeholder="السعر" name="amount" value="{{ $orderProduct->size->price }}">
                                                @error('amount')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-actions">
                                    <a href="{{ route('order.get') }}" type="button" class="btn btn-warning mr-1"
                                        style="color: white">
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
