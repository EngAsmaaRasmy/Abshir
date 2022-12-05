<?php

use App\Http\Controllers\ShopRegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::group(["midelware"=>""]);

        Route::get("/export/categories","shop\\ExcelController@export_categories");
        Route::get("/export/shops","shop\\ExcelController@export_shops");

//Auth::routes();
Route::get("/clear",function (){
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    return "done";
});
Route::get('/migrate', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', array('--force' => true));
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('route:cache');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return "Done";
});
    
use Intervention\Image\Facades\Image;
Route::get("/optimize",function (){
    $products=\App\Models\shop\Product::all();
    foreach ($products as $product){
        if(!is_null($product->image)) {

            $image = Image::make($product->image);

            $image->save($product->image,50,"jpg");
        }
        }

    return "done";
});



Route::get("/","LandingController@index")->name("landing");

Route::get("/abshir-driver-privacy-policy","LandingController@driverPrivacy");
Route::get("/abshir-privacy-policy","LandingController@privacy");

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/get-payment-page/trip/{trip_id}','admin\GeideaPaymentController@getPage');
Route::get('payment-success','admin\GeideaPaymentController@getSuccessPage');
Route::get('payment-failed','admin\GeideaPaymentController@getFailedPage');
Route::post('/paid-success','admin\GeideaPaymentController@paidSuccess');
Route::post('/response','admin\GeideaPaymentController@response');


///----------Charge wallet By Geidea
Route::get('/get-payment-page/customer/{customer_id}/amount/{amount}','admin\GeideaPaymentController@getChargedPage');
Route::post('/done','admin\GeideaPaymentController@chargedSuccess');


Route::get('/get-user-login','admin\AdminLoginController@getUserLogin');
Route::post("/user-login", "admin\AdminLoginController@UserLogin")->name("user.login");

//-------------- shop registeration ------------
Route::get('/shop-register',[ShopRegisterController::class,'create'])->name('shop.create');
Route::post("/shop-register", [ShopRegisterController::class,'store'])->name("shop.register");


