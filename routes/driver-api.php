<?php

use App\Http\Controllers\api\Driver\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccidentTripController;

Route::group(["prefix" => "auth", "middleware" => "guest"], function () {
    Route::post("login", "AuthController@login");
    Route::post("register", "AuthController@register");
    Route::post("/forget-password", "AuthController@forgetPassword");
});

Route::get("cities", "AuthController@cities");
Route::get("transportations", "AuthController@transportations");

Route::middleware("driverMiddleware")->group(function () {
    Route::post('/store-personal-details','AuthController@storePersonalDetails');
    Route::post('/store-car-details','AuthController@storeCarDetails');
    Route::post('/store-documents','AuthController@storeDocuments');
    Route::post('/get-car-markers','AuthController@getCarMarkers');
    Route::post('/get-car-models','AuthController@getCarModels');
    Route::post('/get-governorates','AuthController@getGovernorates');
    Route::post("/check-auth-status", "AuthController@checkAuthenticationStatus");
    Route::post("/get-driver-id", "AuthController@getDriverId");
    Route::post("/checkToken", "AuthController@checkToken");
    Route::post("/refreshToken", "AuthController@refreshToken");
    Route::post("/statistics", "HomeController@index");
    Route::post("/acceptOrder", "OrderController@acceptOrder");
    Route::post("/markOrderAsDelivered", "OrderController@orderDelivered");
    Route::post("/reportProblem", function () {
        return  \App::call('App\Http\Controllers\api\ProblemsController@reportProblem');
    });
    // Route::post("vehicle/data", "AuthController@vehicle_data");
    // Route::post("license/data", "AuthController@license_data");
    // Route::post("identy/data", "AuthController@identy_data");
    // Route::post("address/data", "AuthController@address_data");

    Route::post("/profile/update", "AuthController@updateProfile");
    Route::post("/change-password", "AuthController@changePassword");
    Route::get("/profile", "AuthController@GetProfile");
    Route::post('/get-driver', [HomeController::class, 'getDriverById']);
    Route::post("/driver-profile", "AuthController@profile");
    Route::post("/driver-incomings", "AuthController@incomings");


    // -------- Trip Levels-----------
    Route::post("/approve-trip", "TripController@approveTrip");
    Route::post("/arrive-trip", "TripController@arriveTrip");
    Route::post("/cancel-trip", "TripController@cancelTrip");
    Route::post("/start-trip", "TripController@startTrip");
    Route::post("/finish-trip", "TripController@finishTrip");
    Route::post('/customer-paid-amount','TripController@customerPaidAmount');
    Route::post('/get-inprogress-trips','TripController@inProgresTrips');
    Route::post('/get-finished-trips','TripController@finishedTrips');
    Route::post('/get-trip-details','TripController@getTripDetails');
    Route::post('/end-trip','TripController@endTrip');
    Route::post("avalible/trips", "TripController@avalible_trips");
    Route::post("active/trip", "TripController@active_trip");
    Route::post("cancelled/trips", "TripController@cancelled_trips");
    Route::post("finished/trips", "TripController@finished_trips");
    Route::post("/get-trip-cost", "TripController@getTripCost");



    //-------- special orders ---------
    Route::post("special-orders/get-accept-orders", "SpecialOrderController@getAcceptSpecialOrders");
    Route::post("special-orders/get-accept-order-details", "SpecialOrderController@getAcceptOrderSpecialDetails");
    Route::post("special-orders/get-finished-orders", "SpecialOrderController@getFinishedSpecialOrders");

    Route::post('special-orders/accept','SpecialOrderController@acceptSpecialOrder');
    Route::post('special-orders/receive','SpecialOrderController@receiveSpecialOrder');
    Route::post('special-orders/finish','SpecialOrderController@finishSpecialOrder');





    Route::post("order/{order_id}/accept", "OrderController@acceptOrder");
    Route::post("order/{order_id}/delivery", "OrderController@orderDelivered");

    Route::post("order/{order_id}/ready-to-deliver", "OrderController@ready_to_deliver");
    Route::post("order/{order_id}/on-way", "OrderController@on_way");

    Route::get("active/delivery/orders", "OrderController@active_delivery_orders");
    Route::get("old/delivery/orders", "OrderController@old_delivery_orders");

    Route::get("avalible/delivery/orders", "OrderController@avalible_delivery_orders");
    Route::get("orders/analtycs", "OrderController@analtycs");
    Route::get("orders/analtycs/week/ago", "OrderController@analtycs_week_ago");
    Route::get("orders/analtycs/month/ago", "OrderController@analtycs_1_months_ago");
    Route::get("orders/analtycs/three/months/ago", "OrderController@analtycs_3_months_ago");

    //report an emergency
    Route::post("/report-emergency", "AuthController@reportEmergency");

    Route::post('/make-accident', [AccidentTripController::class,'makeAccident']);

});
