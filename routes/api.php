<?php

use App\Http\Controllers\AccidentTripController;
use App\Http\Controllers\admin\ApiAuthController;
use App\Http\Controllers\api\shop\AuthController;
use App\Http\Controllers\api\shop\OrderController;
use App\Http\Controllers\api\ShopController;
use App\Http\Controllers\api\SpecialOrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\FirebaseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::post('/', [FirebaseController::class, 'create']);
Route::get('/', [FirebaseController::class, 'test']);
// Route::put('/', [FirebaseController::class, 'edit']);
// Route::delete('/', [FirebaseController::class, 'delete']);

Route::group(["prefix" => "auth", "middleware" => "guest"], function () {

    Route::post("/login", "AuthContoller@login");
    Route::post("/register", "AuthController@register");
    Route::post("/check", "AuthController@check");
    
});
Route::middleware("guest")->group(function () {
    Route::post("/initApp", [\App\Http\Controllers\api\AuthController::class, "initApp"]);
    Route::post("/appOffers", "HomeController@getAdminOffers");
    Route::post("/categories", "HomeController@getCategories");
    Route::post("/getShops", "CategoryController@getShops");
    Route::post("/categoryOffers", "CategoryController@getOffers");
    Route::post("/shopCategories", "ShopController@getShopCategories");
    Route::post("/cartProducts", "CartController@getProducts");
    Route::post("/getOffersList", "OfferController@index");
    Route::post("/reportProblem", "ProblemsController@reportProblem");
    Route::post("/getOrderList", "OrderHistoryController@getCurrentOrderList");
    Route::post("/products", [ShopController::class, 'getProducts']);
    Route::post('/search', [ShopController::class, "search"]);
    Route::post("/verifyCoupon", "CartController@verifyCoupon");
    Route::post('/make-special-order', [SpecialOrderController::class, "makeSpecialOrder"]);
    Route::post('/homePage-offers', "HomeController@getHomePageOffers");
    Route::post('/make-accident', [AccidentTripController::class,'makeAccident']);
    Route::post('/get-special-orders', [SpecialOrderController::class, "getSpecialOrders"]);


});
Route::middleware(["apiMiddleware", "localeMiddleware"])->group(function () {
    Route::post("/update-location", "AuthController@update_location");
    Route::post("/refreshToken", "AuthController@refreshToken");
    Route::post("/updateProfile", "AuthController@updateProfile");
    Route::post("/makeOrder", "CartController@makeOrder");

    Route::post('payment-inquiry' , 'PaymentController@PaymentInquiry');
    Route::post('make-payment' , 'PaymentController@DirectPaymentAuthorize');
    Route::post('make-payment-test' , 'PaymentController@testapi');

    Route::post('payment-inquiry' , 'PaymentController@PaymentInquiry');
    Route::post('make-payment' , 'PaymentController@DirectPaymentAuthorize');
    Route::post('make-payment-test' , 'PaymentController@testapi');

    Route::post('/get-driver', 'HomeController@getDriverById');

    // Customer Profile Routes 
    Route::post('/profile', 'AuthController@profile');

    // Trip Routes
    Route::get('get-price-lists','TripController@getPriceLists');
    Route::get('get-payment-types','TripController@getPaymentTypes');
    Route::post('accept-pay', 'TripController@acceptOrRejectPay');
    Route::post('make-trip', 'TripController@make_trip');
    Route::post('cancel-trip', 'TripController@trip_cancellation');
    Route::post('waiting-trips', 'TripController@waiting_trips');
    Route::post('active-trips', 'TripController@active_trips');
    Route::post('cancelled-trips', 'TripController@cancelled_trips');
    Route::post('finished-trips', 'TripController@finished_trips');
    Route::post('finished-trips', 'TripController@finished_trips');
    Route::post('/get-trip-details','TripController@getTripDetails');
    Route::post('/add-driver-review','TripController@addDriverReview');
    Route::post('/get_finish_trip','TripController@getFinishTrip');
    Route::post('/update-payment-trip','TripController@updatePaymentTypeOfTrip');
    Route::post('/get-my-trips','TripController@getMyTrips');
    Route::post('/block-driver','TripController@blockDriver');
    Route::post('/get-block-drivers','TripController@getBlockDrivers');
    Route::post('/unblock-driver','TripController@unBlockDriver');
    Route::post('/add-fav-driver','TripController@addDriverToFav');
    Route::post('/get-fav-drivers','TripController@getFavDrivers');
    Route::post('/remove-fav-driver','TripController@removeDriverFromFav');
    Route::post('/check-coupon', 'TripController@checkCoupon');
    Route::post('/remove-coupon', 'TripController@removeCoupon');




    //Save places
    Route::post('get-save-places','SavePlaceController@getSavePlaces');
    Route::post('save-place','SavePlaceController@savePlace');
    Route::post('unsave-place','SavePlaceController@unSavePlace');

    
    //report an emergency
    Route::post("/report-emergency", "AuthController@reportEmergency");

    //------Contacts
    Route::post('add-contact','CustomerContactController@AddCustomerContact');
    Route::post('get-contacts','CustomerContactController@getCustomerContacts');
    Route::post('delete-contact','CustomerContactController@deleteCustomerContacts');
    Route::post('send-amount-to-contact','CustomerContactController@sendAmountToAnotherContact');

    //------Shared Wallet contacts
    Route::post('add-contact-to-shared-wallet','SharedWalletContactController@AddContactToSharedWallet');
    Route::post('edit-contact-in-shared-wallet','SharedWalletContactController@EDitContactInSharedWallet');
    Route::post('delete-contact-from-shared-wallet','SharedWalletContactController@DeleteContactFromSharedWallet');
    Route::post('get-contacts-in-shared-wallet','SharedWalletContactController@getSharedWalletContacts');

    // --------- shared wallet Group
    Route::post('add-group','SharedWalletContactController@AddGroup');
    Route::post('edit-group','SharedWalletContactController@UpdateGroup');
    Route::post('delete-group','SharedWalletContactController@DeleteGroup');
    Route::post('get-groups-in-shared-wallet','SharedWalletContactController@getSharedWalletGroups');
    Route::post('show-group','SharedWalletContactController@showGroup');
    Route::post('delete-member-from-group','SharedWalletContactController@DeleteMember');
    Route::post('add-new-members-to-exist-group','SharedWalletContactController@AddNewMembersToGroup');

    //------------- get all shared wallet lists -----
    Route::post('get-shared-wallet-lists','SharedWalletContactController@getAllSharedWalletLists');



    //change email 

    Route::post('/send-code-to-email','AuthController@sendCodeToEmail');
    Route::post('/update-email','AuthController@updateEmail');

    //-----Transaction History

    Route::post('/get-transaction-history','HomeController@getTransactionHistory');
});


Route::group(['prefix' => "shop"], function () {
    Route::post('/check', [AuthController::class, "checkToken"]);
    Route::post('/login', [AuthController::class, "login"]);
    Route::group(['middleware' => "auth:shop-api"], function () {
        Route::get('/getProcessingOrders', [OrderController::class, "getProcessingOrders"]);
        Route::post('getNewOrders', [OrderController::class, "getNew"]);
        Route::post('/takeAction', [OrderController::class, "takeAction"]);
        Route::get('logout', [AuthController::class, 'logout']);

    });
});


Route::group(['prefix' => "admin"], function () {
    Route::post('/check', [ApiAuthController::class, "checkToken"]);
    Route::post('/login', [ApiAuthController::class, "login"]);
    Route::group(['middleware' => "auth:admin-api"], function () {
        Route::get('/getProcessingOrders', [OrderController::class, "getProcessingOrders"]);
        Route::post('getNewOrders', [OrderController::class, "getNew"]);
        Route::post('/takeAction', [OrderController::class, "takeAction"]);
        Route::get('logout', [AuthController::class, 'logout']);

    });
});



