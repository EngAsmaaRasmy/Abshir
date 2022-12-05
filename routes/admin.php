<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AdminOrdersController;
use App\Http\Controllers\admin\ChatController;
use App\Http\Controllers\admin\CustomersController;
use App\Http\Controllers\admin\DriverController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\TripController;
use App\Http\Controllers\admin\EmergencyController;
use Illuminate\Support\Facades\Route;
const PAGINATION = 10;
use App\Http\Controllers\admin\FirebaseController;

Route::get('/test', [FirebaseController::class, 'test']);


Route::group(["middleware" => "guest:admin"], function () {
    Route::post("/", "admin\AdminLoginController@adminLogin")->name("admin.login");
    Route::get("/", "admin\AdminLoginController@showAdminLoginForm")->name("get-admin-login");


});

Route::group(["middleware" => "auth:admin"], function () {

    Route::get("/edit-profile", "admin\AdminLoginController@getEditForm")->name("get.admin.edit.profile");
    Route::post("/logout", "admin\AdminLoginController@logout")->name("admin.logout");
    Route::post("/edit-profile", "admin\AdminLoginController@update")->name("admin.profile.edit");
    Route::get('/admin-orders/index', [HomeController::class, "adminOrdersIndex"]);


    Route::get("/home", "admin\HomeController@index")->name("admin.home");
    Route::get("/activity", "admin\HomeController@activity")->name("admin.activity");
    Route::get("/getOrders/{duration}", "admin\HomeController@getToday")->name("admin.statistic");
    Route::get("/getAdminOrders/{duration}", "admin\HomeController@getAdminOrders")->name("get.admin.orders.statistics");
    Route::get("/getDriverDetails/{duration}", "admin\HomeController@getDriversDetails");
    Route::get("/getActivity/{start}/{end}", "admin\HomeController@getActivities")->name("admin.activities");
    Route::post("/searchActivity", "admin\HomeController@searchActivities")->name("activity.search");
    Route::get("/geidea", "admin\GeideaPaymentController@getGeideaDashboard")->name("geidea.history");
    Route::get("/geidea", "admin\GeideaPaymentController@getGeideaDashboard")->name("geidea.history");
    Route::post("/geidea-balance-withdrawal", "admin\GeideaPaymentController@GeideaBalanceWithdrawal")->name("balance.withdrawal");
    
    
    Route::group(["prefix" => "/categories"], function () {
        Route::get("/add", "admin\CategoriesController@showAddForm")->name("get.add.category");
        Route::post("/add", "admin\CategoriesController@save")->name("category.save");
        Route::get("/index", "admin\CategoriesController@show")->name("category.show");
        Route::get("/delete/{id}", "admin\CategoriesController@delete")->name("category.delete");
        Route::get("/edit/{id}", "admin\CategoriesController@edit")->name("category.edit");
        Route::post("/update/{id}", "admin\CategoriesController@update")->name("category.update");

    });
    
    Route::group(["prefix" => "/drivers"], function () {
        Route::get("/get-under-construction", "admin\DriverController@getUnderConstruction")->name("driver.show.getUnderConstruction");
        Route::get("/under-construction/{status}", "admin\DriverController@underConstruction")->name("driver.show.underConstruction");
        Route::get("/awaiting-approval", "admin\DriverController@pending")->name("driver.show.pending");
        Route::get("/approval", "admin\DriverController@approval")->name("driver.show.approval");
        Route::get("/get-blocked", "admin\DriverController@getBlocked")->name("driver.show.getBlocked");
        Route::get("/blocked/{status}", "admin\DriverController@blocked")->name("driver.show.blocked");
        Route::get("/show/{id}", "admin\DriverController@show_driver")->name("driver.show_driver");
        Route::get("/delete/{id}", "admin\DriverController@delete")->name("driver.delete");
        Route::get("/edit/{id}", "admin\DriverController@edit")->name("driver.edit");
        Route::get("/driver-account/{id}", "admin\DriverController@driverAccount")->name("driver.driver_account");
        Route::post("/update/{id}", "admin\DriverController@update")->name("driver.update");
        Route::post("/type-of-use/{id}", "admin\DriverController@typeofUse")->name("driver.typeofUse");
        Route::get("/toggleActive/{id}",[DriverController::class,"toggleActive"])->name("driver.toggle_active");
        Route::get("/wallet/{driverId}",[DriverController::class,"getDriverWallet"])->name("driver.wallet");
        Route::post("/wallet/update",[DriverController::class,"updateDriverWallet"])->name("driver.wallet.update");
        Route::get("add-comment/{id}",[DriverController::class,"editComment"])->name("editComment");
        Route::post("add-comment/{id}",[DriverController::class,"updateComment"])->name("updateComment");
        Route::get('export', [DriverController::class,"export"])->name('export');
        Route::get('day-export', [DriverController::class,"dayExport"])->name('dayExport');

    });


    Route::group(["prefix" => "/shops"], function () {
        Route::get("/add", "admin\ShopController@showAddForm")->name("get.add.shop");
        Route::post("/add", "admin\ShopController@save")->name("shop.save");
        Route::get("/index", "admin\ShopController@show")->name("shop.show");
        Route::get("/delete/{id}", "admin\ShopController@delete")->name("shop.delete");
        Route::get("/edit/{id}", "admin\ShopController@edit")->name("shop.edit");
        Route::post("/update/{id}", "admin\ShopController@update")->name("shop.update");
        Route::post('import', 'admin\ShopController@import')->name('import');

    });


    Route::group(["prefix" => "/orders"], function () {
        Route::get("/add", "admin\AdminOrdersController@showAddForm")->name("show.orders");
        Route::post("/add", "admin\AdminOrdersController@save")->name("order.save");
        Route::get("/index", "admin\AdminOrdersController@show")->name("order.get");
        Route::get("/edit/{id}", "admin\AdminOrdersController@edit")->name("order.edit");
        Route::post("/update/{id}", "admin\AdminOrdersController@update")->name("order.update");
        //-------------- routes for products in orders
        Route::get("/edit-order-product/{orderId}/{id}", "admin\AdminOrdersController@editOrderProduct")->name("orderProduct.edit");
        Route::post("/update-order-product/{id}", "admin\AdminOrdersController@updateOrderProduct")->name("orderProduct.update");
        Route::get("/delete-order-product/{id}","admin\AdminOrdersController@deleteOrderProduct")->name("orderProduct.delete");

        Route::get('/details/{id}', [AdminOrdersController::class, "getDetails"]);
        Route::get('/fetch-shops/{id}', [AdminOrdersController::class, 'fetchShops']);
        Route::get('/fetch-products/{id}', [AdminOrdersController::class, 'fetchProducts']);
        Route::get('/fetch-sizes/{id}', [AdminOrdersController::class, 'fetchSizes']);
        Route::get('/fetch-price/{id}', [AdminOrdersController::class, 'fetchPrice']);
        Route::get('/shop/index', [AdminOrdersController::class, "getShopOrders"]);
        Route::get('/shop/orders', [AdminOrdersController::class, "shopOrders"])->name('customerOrders');
        Route::get('/shop/details/{id}/{type}', [AdminOrdersController::class, "getOrderDetails"]);

    });

    Route::group(["prefix" => "/offers"], function () {
        Route::get("/companyOffers", "admin\OfferController@getCompanyOffers")->name("get.company.offers");
        Route::get("/shopOffers", "admin\OfferController@getShopOffers")->name("get.shop.offers");
        Route::get("/homeOffers", "admin\OfferController@getHomeOffers")->name("get.home.offers");
        Route::get("/shopOffers/add", "admin\OfferController@getShopOfferForm")->name("get.add.Shop.offer");
        Route::get("/homeOffers/add", "admin\OfferController@getHomeOfferForm")->name("get.add.Home.offer");
        Route::get("/companyOffers/add", "admin\OfferController@getCompanyOfferForm")->name("get.add.Company.offer");
        Route::get("/delete/{id}", "admin\OfferController@delete")->name("delete.offer");
        Route::post("/companyOffers/add", "admin\OfferController@addCompanyOffer")->name("company.offer.save");
        Route::post("/shopOffers/add", "admin\OfferController@addShopOffer")->name("shop.offer.save");
        Route::post("/homeOffers/add", "admin\OfferController@addHomeOffer")->name("home.offer.save");
    });


//    Route::group(["prefix"=>"/notifications"],function (){
////        Route::get("/{id}","admin\NotificationController@read")->name("notification.read");
////        Route::get("/","admin\NotificationController@index")->name("notification.get");
//    });

    Route::group(["prefix" => "/notifications"], function () {
        Route::get("/users", "FCMController@getUsersForm")->name("fcm.send.users.form");
        Route::get("/drivers", "FCMController@getdriversForm")->name("fcm.send.drivers.form");
        Route::post("/send", "FCMController@sendToTopic")->name("fcm.send.topic");
        Route::get("/index", "admin\NotificationController@index")->name("get.all");
        Route::get("/read/{id}", "admin\NotificationController@read");
        Route::get("/readAll", "admin\NotificationController@readAll");
        Route::get("/shops", "admin\NotificationController@getSendShopForm")->name('get.send.shops.form');
        Route::post("/shops", "admin\NotificationController@send")->name('send.shop.notification');
    });

    Route::group(["prefix" => "/chats"], function () {
        Route::get("chat", [ChatController::class, "chat"])->name("chat");
        Route::get("chat/{id}", [ChatController::class, "chatRoom"])->name("chatRoom");

    });


    Route::group(["prefix" => "coupons"], function () {
        Route::get("/index", "CouponController@index")->name("coupons.index");
        Route::get("/add", "CouponController@getAddForm")->name("coupons.add");
        Route::get("/edit/{id}", "CouponController@getUpdateForm")->name("coupons.edit");
        Route::get("/delete/{id}", "CouponController@delete")->name("coupons.delete");
        Route::post("/save", "CouponController@save")->name("coupon.save");
        Route::post("/update/{id}", "CouponController@update")->name("coupon.update");
    });

    Route::group(["prefix" => "customers"], function () {
        Route::get("/index", [CustomersController::class, "index"])->name("customers.index");
        Route::get("/toggleActive/{id}",[CustomersController::class,"toggleActive"])->name("customer.toggle_active");
        Route::get("/wallet/{customer_id}",[CustomersController::class,"getCustomerWallet"])->name("customer.wallet");
        Route::post("/update/wallet",[CustomersController::class,"updateCustomerWallet"])->name("customer.wallet.update");

    });

    Route::group(["prefix" => "trips"], function () {
        Route::get("/index", [TripController::class, "index"])->name("trips.index");
        Route::get("/get-trips/{status}", "admin\TripController@getTrips")->name("trips.getTrips");
        Route::get("/show/{id}",[TripController::class,"show"])->name("trips.show");
        Route::get("/add", "admin\TripController@create")->name("get.add.trip");
        Route::post("/trip-cancel", "admin\TripController@cancelTrip")->name("trip.cancel");
        Route::post("/trip-finish", "admin\TripController@finishTrip")->name("trip.finish");
        Route::post("/trip-add", "admin\TripController@store")->name("trip.save");
        Route::post("/customer-add", "admin\TripController@addCustomer")->name("customer.save");
        Route::get("/send-notification/{id}/{tripId}", "admin\TripController@sendNotification")->name("trip.sendNotification");

    });


    Route::group(["prefix" => "roles"], function () {
        Route::get("/add", "admin\RoleController@create")->name("get.add.role");
        Route::post("/add", "admin\RoleController@store")->name("role.save");
        Route::get("/index", "admin\RoleController@index")->name("role.index");
        Route::get("/edit/{id}", "admin\RoleController@edit")->name("role.edit");
        Route::get("/delete/{id}", "admin\RoleController@destroy")->name("role.delete");
        Route::post("/update/{id}", "admin\RoleController@update")->name("role.update");
        Route::post("/add-permission", "admin\RoleController@addPermission")->name("add.permission");
    });

    Route::group(["prefix" => "admins"], function () {
        Route::get("/add", "admin\AdminController@create")->name("get.add.admin");
        Route::post("/add", "admin\AdminController@store")->name("admin.save");
        Route::get("/index", "admin\AdminController@index")->name("admin.index");
        Route::get("/edit/{id}", "admin\AdminController@edit")->name("admin.edit");
        Route::get("/delete/{id}", "admin\AdminController@destroy")->name("admin.delete");
        Route::post("/update/{id}", "admin\AdminController@update")->name("admin.update");
        Route::get("/wallet/{admin_id}", "admin\AdminController@getWallet")->name("admin.wallet");
        Route::post("/wallet/update", "admin\AdminController@updateWallet")->name("admin.wallet.update");
    });


    Route::group(["prefix" => "/settings"], function () {
        Route::get('governorate-index','admin\GovernoratesController@index')->name('governorate.index');
        Route::get('governorate.add','admin\GovernoratesController@add')->name('governorate.add');
        Route::post('governorate.save','admin\GovernoratesController@save')->name('governorate.save');
        Route::get('governorate.edit/{id}','admin\GovernoratesController@edit')->name('governorate.edit');
        Route::post('governorate.update','admin\GovernoratesController@update')->name('governorate.update');
        Route::get('governorate.delete/{id}','admin\GovernoratesController@delete')->name('governorate.delete');

        Route::get('car-markers-index','admin\AdminCarMarkersController@index')->name('carMarkers.index');
        Route::get('carMarkers.add','admin\AdminCarMarkersController@add')->name('carMarkers.add');
        Route::post('carMarkers.save','admin\AdminCarMarkersController@save')->name('carMarkers.save');
        Route::get('carMarkers.edit/{id}','admin\AdminCarMarkersController@edit')->name('carMarkers.edit');
        Route::post('carMarkers.update','admin\AdminCarMarkersController@update')->name('carMarkers.update');
        Route::get('carMarkers.delete/{id}','admin\AdminCarMarkersController@delete')->name('carMarkers.delete');
        Route::post('import-car-markers', 'admin\AdminCarMarkersController@import')->name('importCarMarkers');

        Route::get('car-models-index','admin\AdminCarModelsController@index')->name('carModels.index');
        Route::get('carModels.add','admin\AdminCarModelsController@add')->name('carModels.add');
        Route::post('carModels.save','admin\AdminCarModelsController@save')->name('carModels.save');
        Route::get('carModels.edit/{id}','admin\AdminCarModelsController@edit')->name('carModels.edit');
        Route::post('carModels.update','admin\AdminCarModelsController@update')->name('carModels.update');
        Route::get('carModels.delete/{id}','admin\AdminCarModelsController@delete')->name('carModels.delete');
        Route::post('import-car-models', 'admin\AdminCarModelsController@import')->name('importCarModels');

        Route::get('price-lists-index','admin\PriceListController@index')->name('priceLists.index');
        Route::get('priceLists-add','admin\PriceListController@create')->name('priceLists.add');
        Route::post('priceLists-save','admin\PriceListController@store')->name('priceLists.save');
        Route::get('priceLists-edit/{id}','admin\PriceListController@edit')->name('priceLists.edit');
        Route::post('priceLists-update','admin\PriceListController@update')->name('priceLists.update');

        Route::get('discount-settings-index','admin\DiscountSettingsController@index')->name('discountSettings.index');
        Route::get('discountSettings-add','admin\DiscountSettingsController@create')->name('discountSettings.add');
        Route::post('discountSettings-save','admin\DiscountSettingsController@store')->name('discountSettings.save');
        Route::get('discountSettings-edit/{id}','admin\DiscountSettingsController@edit')->name('discountSettings.edit');
        Route::post('discountSettings-update','admin\DiscountSettingsController@update')->name('discountSettings.update');
    });

    Route::group(["prefix" => "emergency"], function () {
        Route::get("/index", "admin\EmergencyController@index")->name("emergency.index");
        Route::get("/get-all", "admin\EmergencyController@getAllEmergencies")->name("getAllEmergencies");
        Route::get("/show/{id}", "admin\EmergencyController@show")->name("emergency.show");

    });

});

