<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true" style="touch-action: none; user-select: none; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);">
    <div class="main-menu-content ps ps--active-y">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li  style=""><a class="menu-item" href="{{route("shop.home")}}"><i class="ft-pie-chart"></i><span data-i18n="Sales">الاحصائيات</span></a> </li>

            <li class="nav-item has-sub @if(request()->is("shop/categories/*")) open @endif"><a href="#"><i class="fa ft-grid"></i><span class="menu-title" data-i18n="الاقسام">اقسام المحل</span></a>
                <ul class="menu-content" style="">
                    <li class="@if(request()->is("shop/categories/add")) active @endif"><a class="menu-item " href="{{route("display.categories.add.form")}}">اضافه</a>
                    </li>
                    <li class="@if(request()->is("shop/categories/index")) active @endif"><a class="menu-item " href="{{route("display.categories")}}">عرض الكل</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-sub @if(request()->is("shop/products/*")) open @endif "><a href="#"><i class="ft-shopping-bag"></i>
                    <span class="menu-title" data-i18n="المنتجات">المنتجات</span>
                </a>

                <ul class="menu-content " style="">
                    <li class="@if(request()->is("shop/products/index")) active @endif"><a class="menu-item " href="{{route("display.products")}}">عرض الكل</a>
                    </li>
                    <li class="@if(request()->is("shop/products/addSingle")) active @endif"><a class="menu-item " href="{{route("display.product.add.single.form")}}">اضافه منتج واحد</a>
                    </li>
                    <li class="@if(request()->is("shop/products/addMulti")) active @endif"><a class="menu-item " href="{{route("display.product.add.multi.form")}}">اضافه منتجات متعدده</a>
                    </li>
                    <li class="@if(request()->is("shop/products/getExportView")) active @endif"><a class="menu-item " href="{{route("product.export.view")}}">تصدير المنتجات</a>
                    </li>


                </ul>
            </li>
            <li class="nav-item has-sub @if(request()->is("shop/orders/*")) open @endif"><a href="#"><i class="ft-shopping-cart"></i><span class="menu-title" data-i18n="الاقسام">الطلبات</span></a>
                <ul class="menu-content" style="">


                    <li class="@if(request()->is("shop/orders/active")) active @endif"><a class="menu-item " href="{{route("get.active.orders")}}">الطلبات الجارية</a>
                    </li>
                    <li class="@if(request()->is("shop/orders/all")) active @endif"><a class="menu-item " href="{{route("get.all.orders")}}">عرض الكل</a>
                    </li>


                </ul>
            </li>
            <li class="nav-item has-sub @if(request()->is("admin/drivers/*")) open @endif"><a href="#"><i class="fa fa-bullhorn"></i><span class="menu-title" data-i18n="العروض">عروض</span></a>
                <ul class="menu-content" style="">

                    <li class="@if(request()->is("admin/drivers/add")) active @endif"><a class="menu-item " href="{{route("display.all.offers")}}">عرض الكل</a>
                    </li>


                </ul>
            </li>

            <li class="nav-item has-sub @if(request()->is("shop/notifications/*")) open @endif"><a href="#"><i class="fa fa-phone"></i><span class="menu-title" data-i18n="الاقسام">التواصل</span></a>
                <ul class="menu-content" style="">

                    <li class="@if(request()->is("shop/notifications/sendToAdmin")) active @endif"><a class="menu-item " href="{{route("get.send.admin.form")}}">ارسال رسالة الى الاداره</a>
                    </li>
                </ul>
            </li>


        </ul>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; height: 587px; left: 255px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 78px;"></div></div></div>
</div>
