<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="fa"
 style="height: 100%;
 position: fixed;
 padding: 0px;
 margin-top: -50px;
 padding-top: 50px;
">
    <div class="main-menu-content ps ps--active-y scroll"
    style=" height:95%;
    position: relative;
    overflow-y: scroll;">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @can('الصفحة الرئيسية')
            <li  style=""><a class="menu-item" href="{{route("admin.home")}}"><i class="ft-pie-chart"></i><span data-i18n="Sales">الاحصائيات</span></a> </li>
            @endcan
            @can('نشاطات المستخدمين')
            <li  style=""><a class="menu-item" href="{{route("admin.activity")}}"><i class="ft-sliders"></i><span data-i18n="Sales">انشطة المستخدمين</span></a> </li>
            @endcan
            @can('عرض المستخدمين')
            <li class="nav-item has-sub @if(request()->is("admin/admins/*")) open @endif "><a href="#">المستخدمين<i class="ft-user"></i>
            </a>

                <ul class="menu-content " style="">
                    @can('عرض المستخدمين')
                    <li class="@if(request()->is("admin/admins/index")) active @endif"><a class="menu-item " href="{{route("admin.index")}}">عرض الكل</a>
                    </li>
                    @endcan
                    @can('إضافة مستخدمين')
                    <li class="@if(request()->is("admin/admins/add")) active @endif"><a class="menu-item " href="{{route("get.add.admin")}}">اضافه</a>
                    </li>
                    @endcan

                </ul>
           </li>
           @endcan
           @can('عرض الصلاحيات')
           <li class="nav-item has-sub @if(request()->is("admin/roles/*")) open @endif "><a href="#">الصلاحيات<i class="ft-activity"></i>
           </a>

            <ul class="menu-content " style="">
                @can('عرض الصلاحيات')
                <li class="@if(request()->is("admin/roles/index")) active @endif"><a class="menu-item " href="{{route("role.index")}}">عرض الكل</a>
                </li>
                @endcan
                @can('إضافة صلاحية')
                <li class="@if(request()->is("admin/roles/add")) active @endif"><a class="menu-item " href="{{route("get.add.role")}}">اضافه</a>
                </li>
                @endcan


            </ul>
          </li>
          @endcan
          @can('عرض الاقسام')
            <li class="nav-item has-sub @if(request()->is("admin/categories/*")) open @endif "><a href="#"><i class="ft-grid"></i>
                    <span class="menu-title" data-i18n="الاقسام">الاقسام</span>
                    <span class="badge badge badge-pill badge-info float-right mr-2">{{\App\Models\admin\CategoryModel::all()->count()}}</span>
                </a>

                <ul class="menu-content " style="">
                    @can('عرض الاقسام')
                    <li class="@if(request()->is("admin/categories/index")) active @endif"><a class="menu-item " href="{{route("category.show")}}">عرض الكل</a>
                    </li>
                    @endcan
                    @can('إضافة قسم')
                    <li class="@if(request()->is("admin/categories/add")) active @endif"><a class="menu-item " href="{{route("get.add.category")}}">اضافه</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('عرض الطلبات')
            <li class="nav-item has-sub @if(request()->is("admin/orders/*")) open @endif"><a href="#"><i class="ft-shopping-bag"></i><span class="menu-title" data-i18n="الاقسام">الطلبات</span></a>
                <ul class="menu-content" style="">

                    {{-- @can('عرض الطلبات') --}}
                    <li class="@if(request()->is("admin/orders/index")) active @endif"><a class="menu-item " href="{{route("order.get")}}">عرض الطلبات الخاصة</a>
                    </li>

                    <li class="@if(request()->is("admin/orders/shop/orders")) active @endif"><a class="menu-item " href="{{route("customerOrders")}}">عرض الطلبات </a>
                    </li>

                    {{-- @endcan --}}
                    @can('إضافة طلب')
                    <li class="@if(request()->is("admin/orders/add")) active @endif"><a class="menu-item " href="{{route("show.orders")}}">اضافه طلب خاص</a>
                    </li>
                    @endcan


                </ul>
            </li>
            @endcan
            @can('عرض العملاء')
            <li class="nav-item has-sub @if(request()->is("admin/customers/*")) open @endif"><a href="#"><i class="fa fa-motorcycle"></i><span class="menu-title" data-i18n="الاقسام">العملاء</span></a>
                <ul class="menu-content" style="">
                    <li class="@if(request()->is("admin/customers/index")) active @endif"><a class="menu-item " href="{{route('customers.index')}}">عرض الكل</a>
                    </li>

                </ul>
            </li>
            @endcan
            @can('السائقين')
            <li class="nav-item has-sub @if(request()->is("admin/drivers/*")) open @endif"><a href="#"><i class="fa fa-motorcycle"></i><span class="menu-title" data-i18n="الاقسام">السائقين</span></a>
                <ul class="menu-content" style="">
                    {{-- Under construction --}}
                    @can('تصدير كل السائقين')
                    <li class="@if(request()->is("admin/drivers/export")) active @endif"><a class="menu-item " href="{{route('export')}}"> تصدير تسجيلات السائقين</a>
                    </li>
                    @endcan
                    @can('تصدير تسجيلات السائقين لهذا اليوم')
                    <li class="@if(request()->is("admin/drivers/day-export")) active @endif"><a class="menu-item " href="{{route('dayExport')}}">   تصدير تسجيلات السائقين  لليوم</a>
                    </li>
                    @endcan
                    @can('عرض السائقين تحت الإنشاء')
                    <li class="@if(request()->is("admin/drivers/get-under-construction")) active @endif"><a class="menu-item " href="{{route('driver.show.getUnderConstruction')}}"> سائقين تحت الإنشاء</a>
                    </li>
                    @endcan
                    @can('عرض السائقين بإنتظار الموافقة عليهم')
                    <li class="@if(request()->is("admin/drivers/awaiting-approval")) active @endif"><a class="menu-item " href="{{route('driver.show.pending')}}"> سائقين بإنتظار الموافقة</a>
                    </li>
                    @endcan
                    @can('عرض السائقين تم تفعيل حسابهم')
                    <li class="@if(request()->is("admin/drivers/approval")) active @endif"><a class="menu-item " href="{{route('driver.show.approval')}}"> سائقين تم تفعيل حسابهم </a>
                    </li>
                    @endcan
                    @can('عرض السائقين المحظورين')
                    <li class="@if(request()->is("admin/drivers/get-blocked")) active @endif"><a class="menu-item " href="{{route('driver.show.getBlocked')}}"> سائقين محظورين</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('عرض المحلات')
            <li class="nav-item has-sub @if(request()->is("admin/shops/*")) open @endif "><a href="#"><i class="fa fa-university"></i><span class="menu-title" data-i18n="الاقسام">المحلات</span></a>
                <ul class="menu-content" style="">
                    @can('عرض المحلات')
                    <li class="@if(request()->is("admin/shops/index")) active @endif"><a class="menu-item " href="{{route("shop.show")}}">عرض الكل</a>
                    </li>
                    @endcan
                    @can('إضافة محل')
                    <li class="@if(request()->is("admin/shops/edit")) active @endif"><a class="menu-item " href="{{route("get.add.shop")}}">اضافه</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('عرض الرحلات')
            <li class="nav-item has-sub @if(request()->is("admin/trips/*")) open @endif "><a href="#"><i class="fa fa-university"></i><span class="menu-title" data-i18n="الاقسام">الرحلات</span></a>
                <ul class="menu-content" style="">
                    @can('عرض الرحلات')
                    <li class="@if(request()->is("admin/trips/index")) active @endif"><a class="menu-item " href="{{route("trips.index")}}">عرض الكل</a>
                    </li>
                    @endcan
                    @can('إضافة رحلة')
                    <li class="@if(request()->is("admin/trips/add")) active @endif"><a class="menu-item " href="{{route("get.add.trip")}}">اضافه</a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcan
            @can('الكوبونات')
            <li class="nav-item has-sub @if(request()->is("admin/coupons/*")) open @endif "><a href="#"><i class="fa fa-percent"></i><span class="menu-title" data-i18n="الاقسام">كوبونات</span></a>
                <ul class="menu-content" style="">
                    <li class="@if(request()->is("admin/coupons/index")) active @endif"><a class="menu-item " href="{{route("coupons.index")}}">عرض الكل</a>
                    </li>
                    <li class="@if(request()->is("admin/coupons/add")) active @endif"><a class="menu-item " href="{{route("coupons.add")}}">اضافه</a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('العروض')
            <li class="nav-item has-sub @if(request()->is("admin/offers/*")) open @endif"><a href="#"><i class="fa fa-bullhorn"></i><span class="menu-title" data-i18n="الاقسام">العروض</span></a>
                <ul class="menu-content" style="">
                    @can('عروض الشركات')
                    <li class="@if(request()->is("admin/offers/companyOffers")) active @endif"><a class="menu-item " href="{{route('get.company.offers')}}">عروض الشركه</a>
                    </li>
                    @endcan
                    @can('عروض المحلات')
                    <li class="@if(request()->is("admin/offers/shopOffers")) active @endif"><a class="menu-item " href="{{route('get.shop.offers')}}">عروض المحلات</a>
                    </li>
                    @endcan
                    @can('عروض الصفحة الرئيسية')
                    <li class="@if(request()->is("admin/offers/homeOffers")) active @endif"><a class="menu-item " href="{{route('get.home.offers')}}">عروض الصفحة الرئيسة</a>
                    </li>
                    @endcan
                    @can('إضافة عرض شركة')
                    <li class="@if(request()->is("admin/offers/companyOffers/add")) active @endif"><a class="menu-item " href="{{route("get.add.Company.offer")}}">اضافة عرض للشركه</a>
                    </li>
                    @endcan
                    @can('إضافة عرض محل')
                    <li class="@if(request()->is("admin/offers/shopOffers/add")) active @endif"><a class="menu-item " href="{{route("get.add.Shop.offer")}}">اضافة عرض للمحلات</a>
                    </li>
                    @endcan
                    @can('إضافة عرض للصفحة الرئيسية')
                    <li class="@if(request()->is("admin/offers/homeOffers/add")) active @endif"><a class="menu-item " href="{{route("get.add.Home.offer")}}">اضافة عرض للصفحة الرئيسية</a>
                    </li>
                    @endcan

                </ul>
            </li>
            @endcan
            @can('الإشعارات')
            <li class="nav-item has-sub @if(request()->is("admin/notifications/*")) open @endif "><a href="#"><i class="fa fa-bell-o"></i><span class="menu-title" data-i18n="الاقسام">الاشعارات</span></a>
                <ul class="menu-content" style="">
                    <li class="@if(request()->is("admin/notifications/users")) active @endif"><a class="menu-item " href="{{route("fcm.send.users.form")}}">ارسال اشعارات للمستخدمين </a>
                    </li>
                    <li class="@if(request()->is("admin/notifications/drivers")) active @endif"><a class="menu-item " href="{{route("fcm.send.drivers.form")}}">ارسال اشعارات للسائقين </a>
                    </li>
                    <li class="@if(request()->is("admin/notifications/shops")) active @endif"><a class="menu-item " href="{{route("get.send.shops.form")}}">ارسال اشعارات للمحلات </a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('المحادثة')
                <li class="@if(request()->is("admin/chats/chat")) active @endif"><a class="menu-item " href="{{route("chat")}}"><i class="fa fa-bell-o"></i> المحادثات</a>
                </li>
            </li>
            @endcan
            @can('الإعدادات')
            <li class="nav-item has-sub @if(request()->is("admin/settings/*")) open @endif ">
                <a href="#"><i class="ft-grid"></i>
                     <span class="menu-title" data-i18n="الاقسام">الاعدادت</span>
                </a>

                    <ul class="menu-content " style="">
                        @can('عرض المحافظات')
                        <li ><a class="menu-item @if(request()->is("admin/settings/governorate-index")) active @endif" href="{{route("governorate.index")}}"> المحافظات</a>
                        </li>
                        @endcan
                        @can('عرض ماركات السيارات')
                        <li ><a class="menu-item @if(request()->is("admin/settings/car-markers-index")) active @endif" href="{{route("carMarkers.index")}}">ماركات السيارات</a>
                        </li>
                        @endcan
                        @can('عرض موديلات السيارات')
                        <li ><a class="menu-item @if(request()->is("admin/settings/car-models-index")) active @endif" href="{{route("carModels.index")}}">موديلات السيارات</a>
                        </li>
                        @endcan
                        @can('عرض قائمة الأسعار')
                        <li ><a class="menu-item @if(request()->is("admin/settings/price-lists-index")) active @endif" href="{{route("priceLists.index")}}"> قائمة الأسعار</a>
                        </li>
                        @endcan
                        @can('عرض إعدادات الخصم')
                        <li ><a class="menu-item @if(request()->is("admin/settings/discount-settings-index")) active @endif" href="{{route("discountSettings.index")}}"> إعدادات الخصم</a>
                        </li>
                        @endcan


                </ul>
            </li>
            @endcan
            @can('حالات الطوارئ')
            <li class="nav-item has-sub @if(request()->is("admin/settings/*")) open @endif ">
                <a href="#"><i class="fa fa-bullhorn"></i>
                    <span class="menu-title" data-i18n="الطوارئ">حالات  الطوارئ </span>
                </a>
                    <ul class="menu-content " style="">
                        @can('عرض حالات الطوارئ')
                        <li ><a class="menu-item @if(request()->is("admin/emergency/index")) active @endif" href="{{route("emergency.index")}}"> عرض الكل
                        </a>
                        </li>
                        @endcan
                </ul>
            </li>
            @endcan
             @can('احصائيات الدفع')
            <li  style=""><a class="menu-item" href="{{route("geidea.history")}}"><i class="ft-pie-chart"></i><span data-i18n="Sales">Geidea احصائيات</span></a> </li>
            @endcan
        </ul>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;">
            </div>
        </div>
    </div>

</div>
