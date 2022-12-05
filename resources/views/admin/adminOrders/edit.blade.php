{{-- @extends("admin.app2") --}}
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords"
        content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>HMF - لوحة تحكم الادمن</title>

    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic&family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors-rtl.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/datatables.min.css') }}">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> --}}


    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/bootstrap-extended.css') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/custom-rtl.css') }}">

    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/css-rtl/core/menu/menu-types/vertical-menu-modern.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/single-page.css') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/HomeStyle.css') }}">

</head>

<body
    class="vertical-layout vertical-collapsed-menu 2-columns fixed-navbar pace-done menu-expanded vertical-menu-modern"
    data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99"
            style="transform: translate3d(100%, 0px, 0px); font-family: Almarai,sans-serif">



            <div class="pace-progress-inner"></div>

            <div class="pace-activity"></div>

        </div>
    </div>
    <div>
        <div class="pace  pace-inactive">
            <div class="pace-progress" data-progress-text="100%" data-progress="99"
                style="transform: translate3d(100%, 0px, 0px); font-family: Almarai,sans-serif">



                <div class="pace-progress-inner"></div>

                <div class="pace-activity"></div>

            </div>
        </div>

        <div id="app">
            @include('admin.layout.header')

            @include('admin.layout.sidebar')

            <div class="app-content content ">
                <div class="content-overlay"></div>
                <div class="content-wrapper ">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">

                        <div class="card form-card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-form">تعديل طلب </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    @include('alert.success')
                                    @include('alert.error')
                                    <form class="form" method="post" action="{{ route('order.update', $order->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-shopping-bag"></i> معلومات الطلب</h4>
                                            {{-- <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput3"> الفئة </label>
                                                        <select id="category" name="category_id"
                                                            class="select2 form-control" required>
                                                            @foreach (\App\Models\admin\CategoryModel::where('active', 1)->get() as $category)
                                                                {
                                                                <option value={{ $category->id }} {{$order->category_id == $category->id  ? 'selected' : ''}}>
                                                                    {{ $category->name_ar }}</option>
                                                                }
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2"> المحل </label>
                                                        <select name="shop_id" class="select2 form-control"
                                                            id="shop" required>
                                                            @foreach (\App\Models\admin\ShopModel::where('category', $order->category_id)->where('active', 1)->get() as $shop)
                                                            {
                                                            <option value={{ $shop->id }} {{$order->shop == $shop->id  ? 'selected' : ''}}>
                                                                {{ $shop->name }}</option>
                                                            }
                                                        @endforeach
                                                        </select>

                                                    </div>
                                                </div>

                                            </div> --}}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">رقم هاتف العميل</label>
                                                        <input type="text" id="projectinput1"
                                                            class="form-control  @error('customer_phone') is-invalid @enderror"
                                                            placeholder="رقم هاتف العميل" name="customer_phone" value="{{ $order->customer_phone }}">

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2">اسم العميل</label>
                                                        <input type="text" id="projectinput2"
                                                            class="form-control @error('customer_name') is-invalid @enderror"
                                                            placeholder="اسم العميل" name="customer_name" value="{{ $order->customer_name }}">

                                                    </div>
                                                </div>


                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <label for="projectinput1">العنوان</label>
                                                        <fieldset class="form-group">
                                                            <textarea style="margin-right: 0" name="customer_address"
                                                                class="form-control @error('customer_address') is-invalid @enderror" id="placeTextarea" rows="3"
                                                                placeholder="عنوان العميل">{{ $order->customer_address }}</textarea>
                                                        </fieldset>
                                                        @error('customer_address')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>



                                            </div>
                                            {{-- <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2">تكلفه التوصيل</label>
                                                        <input type="text" id="projectinput2"
                                                            class="form-control  @error('delivery_cost') is-invalid @enderror"
                                                            placeholder="تكلفه التوصيل" value="{{ $order->delivery_cost }}" name="delivery_cost">
                                                        @error('delivery_cost')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput3">المبلغ المستحق من المندوب</label>
                                                        <input type="text" id="projectinput3"
                                                            class="form-control @error('must_paid') is-invalid @enderror"
                                                            placeholder="المبلغ المستحق من المندوب" value="{{ $order->must_paid }}" name="must_paid">
                                                        @error('must_paid')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <div class="row">
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <label for="projectinput1">تفاصيل الطلب</label>
                                                        <fieldset class="form-group">
                                                            <textarea style="margin-right: 0" name="details" class="form-control @error('details') is-invalid @enderror"
                                                                id="placeTextarea" rows="3" placeholder="تفاصيل الطلب">{{ $order->details }}</textarea>
                                                        </fieldset>
                                                        @error('details')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput2"> السائق </label>
                                                        <select name="driver_id" class="select2 form-control"
                                                            required>
                                                            <option disabled label="من فضلك اختر سائق ">من فضلك اختر السائق</option>
                                                                @foreach (\App\Models\admin\DriverModel::where('active', 1)->get() as $driver)
                                                                    {
                                                                    <option value={{ $driver->id }} {{$order->driver_id == $driver->id  ? 'selected' : ''}}>
                                                                        {{ $driver->fullname }}</option>
                                                                    }
                                                                @endforeach
                                                        </select>
                                                        @error('driver_id')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <hr>

                                        {{-- <h4 class="form-section"><i ></i>  المنتجات</h4>
                                        <div class="table-responsive-lg">
                                            <table class="table fixed">
                                                <thead class="bg-primary white">
                                                    <tr>
    
                                                        <th>المٌنتج</th>
                                                        <th>الحجم</th>
                                                        <th>الكمية</th>
                                                        <th>السعر</th>
                                                        <th>الاجراءات</th>
    
                                                    </tr>
                                                </thead>
                                                <tbody>
    
                                                    @foreach ($orderProducts as $orderProduct)
                                                        <tr>
                                                            <td>{{ $orderProduct->productRel->name_ar }}</td>
                                                            <td>{{ $orderProduct->size->name }}</td>
                                                            <td>{{ $orderProduct->amount }}</td>
                                                            <td>{{ $orderProduct->size->price }}</td>
    
                                                            <td>
                                                                <div class="btn-group" role="group"
                                                                    aria-label="Basic example">
                                                                    <a href="{{ route('orderProduct.delete', $orderProduct->id) }}"
                                                                        class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1">حذف</a>
    
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
    
    
                                                </tbody>
                                            </table>
                                        </div> --}}
    
                                        {{-- <h4 class="form-section"><i class="ft-shopping-bag"></i>اضافه مٌنتجات جديدة</h4> --}}
                                        
                                        {{-- <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="form-control" id="product" required>
                                                            <option value="">من فضلك اختار المنتج</option>
                                                            @foreach (\App\Models\shop\Product::where('shop', $order->shop)->get() as $product)
                                                            {
                                                            <option value="{{ $product->id }}">
                                                                {{ $product->name_ar }}</option>
                                                            }
                                                            @endforeach
                                                        </select>

                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <select class="form-control" id="size" required>
                                                            <option value="">من فضلك اختار الحجم</option>
                                                        </select>
                                                    </div>

                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="number" id="quantity" min="1"
                                                            class="form-control amount" placeholder="الكمية"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="col-md-2" style="color: white;">
                                                    <a class="btn btn-success" id="add-row">
                                                        <i class="ft-plus"></i> إضافة</a>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="container">
                                                <table class="table" id="products_table">
                                                    <thead>
                                                        <tr>
                                                            <th><input type="checkbox" id="select-all"> الكل</th>
                                                            <th>المُنتج </th>
                                                            <th>الحجم </th>
                                                            <th>الكمية</th>
                                                            <th>السعر</th>
                                                            <th>المجموع</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="checkbox" id="select-row"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <a class="btn btn-danger mr-1 remove-row" id="remove-row"
                                                    style="color: white;">
                                                    <i class="ft-x"></i> حذف
                                                </a>

                                            </div>
                                            <div class="continer">
                                                <div class="row" style="margin-top:20px">
                                                    <div class="pull-right col-md-4">
                                                        <table class="table table-bordered table-hover"
                                                            id="tab_logic_total">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <div class="input-group mb-2 mb-sm-0">
                                                                            <input type="number"
                                                                                class="form-control" readonly
                                                                                id="tax" placeholder="0" hidden>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-center">المجموع </th>
                                                                    <td class="text-center"><input type="number"
                                                                            name='total' id="total_amount"
                                                                            placeholder='0.00'
                                                                            class="form-control" readonly /></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="form-actions">
                                            <a type="button" class="btn btn-warning mr-1" style="color: white">
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
        </div>

        @include('admin.layout.footer')

    </div>
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>


    <script src="{{ asset('app-assets/js/vendors.min.js') }}"></script>

    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/jquery.repeater.js') }}"></script>



    <script src="{{ asset('app-assets/js/datatables.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>


    <script type="module" src="{{ asset('assets/js/order-js.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
