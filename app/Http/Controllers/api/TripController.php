<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\admin\CategoryModel;
use App\Models\admin\OfferModel;
use App\Http\Resources\TripResource;
use App\Models\admin\PriceList;
use App\Models\Trip;
use App\traits\ResonseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;
use App\Http\Requests\Trip\MakeTripRequest;
use App\Http\Requests\Trip\CancelTripRequest;
use App\Models\admin\DiscountSetting;
use App\Models\Wallet;
use App\Helpers\WalletHistoryGeneralHelper;
use App\Http\Requests\Trip\AcceptPayRequest;
use App\Http\Requests\Trip\AddDriverReviewRequest;
use App\Http\Requests\Trip\EndTripRequest;
use App\Models\admin\DriverModel;
use App\Models\AdminWallet;
use App\Models\BlockDrivers;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\Customer;
use App\Models\DriverReview;
use App\Models\Emergency;
use App\Models\FavoriteDrivers;
use App\Models\PayForMeHistory;
use App\Models\TypeOfPayment;
use App\SharedWalletHistory;
use Illuminate\Support\Facades\Auth;
use DB;

class TripController extends Controller
{
    use ResonseTrait;
    public function getPriceLists()
    {
        $priceLists = PriceList::select('price_lists.id', 'price_lists.name', 'price_lists.kilo_price', 'price_lists.minute_price', 'price_lists.start_price')->get();
        return $this->returnData($priceLists, 'تم الحصول على قائمه الاسعار');
    }
    public function getPaymentTypes()
    {
        $type_of_payments = TypeOfPayment::select('id', 'type')->get();
        return $this->returnData($type_of_payments, 'تم الحصول على طُرق الدفع ');
    }
    public  function make_trip(MakeTripRequest $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            if ($request->has('coupon_id')) {
                $coupon = Coupon::where("id", $request->coupon_id)->where("max_count", ">", "current_count")->where("expire_date", ">=", Carbon::today())->first();
                if ($coupon) {
                    $coupon->increment("current_count");
                    CouponUser::create([
                        "coupon" => $coupon->id,
                        "user" => $customer->id,
                    ]);
                    $trip = $this->store_trip(
                        $customer->id,
                        $request->price_list_id,
                        $request->start_lat,
                        $request->start_long,
                        $request->end_lat,
                        $request->end_long,
                        'created',
                        $request->type_of_payment,
                        $request->coupon_id
                    );

                    if ($trip->type_of_payment == "3") {
                        $payHistory = PayForMeHistory::where('id', $request->pay_history_id)->first();
                        $payHistory->update([
                            'trip_id' => $trip->id,
                        ]);
                    } else if ($trip->type_of_payment == "4") {
                        SharedWalletHistory::create([
                            'trip_id' => $trip->id,
                            'customer_contact_id' => $request->customer_contact_id,
                            'type' => $request->type,
                        ]);
                    }
                    return $this->returnData(['trip_id' => $trip->id], "تم إضافه الرحله بنجاح");
                } else {
                    return $this->returnError("كوبون غير صالح");
                }
            } else {
                $trip = $this->store_trip(
                    $customer->id,
                    $request->price_list_id,
                    $request->start_lat,
                    $request->start_long,
                    $request->end_lat,
                    $request->end_long,
                    'created',
                    $request->type_of_payment,
                    NULL
                );

                if ($trip->type_of_payment == "3") {
                    $payHistory = PayForMeHistory::where('id', $request->pay_history_id)->first();
                    $payHistory->update([
                        'trip_id' => $trip->id,
                    ]);
                } else if ($trip->type_of_payment == "4") {
                    SharedWalletHistory::create([
                        'trip_id' => $trip->id,
                        'customer_contact_id' => $request->customer_contact_id,
                        'type' => $request->type,
                    ]);
                }
                return $this->returnData(['trip_id' => $trip->id], "تم إضافه الرحله بنجاح");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public  function store_trip($customerId, $price_list_id, $start_lat, $start_long, $end_lat, $end_long, $status, $type_of_payment, $coupon_id)
    {
        $trip = Trip::create([
            'client_id' => $customerId,
            'price_list_id' => $price_list_id,
            'start_lat' => $start_lat,
            'start_long' => $start_long,
            'end_lat' => $end_lat,
            'end_long' => $end_long,
            'type_of_payment' => $type_of_payment,
            'status' => 'created',
            'coupon_id' => $coupon_id,
        ]);

        return $trip;
    }

    public  function acceptOrRejectPay(AcceptPayRequest $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $payHistory = PayForMeHistory::create([
                'contact_id' => $customer->id,
                'status' => $request->status,
            ]);
            if ($payHistory->status == "Accepted") {
                return $this->returnData(['pay_history_id' => $payHistory->id], "تم قبول عملية الدفع بنجاح");
            } else {
                return $this->returnData(['pay_history_id' => $payHistory->id], "تم رفض عملية الدفع ");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function trip_cancellation(CancelTripRequest $request)
    {

        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $trip = Trip::where('id', $request->trip_id)->where('client_id', $customer->id)->first();

            if ($trip && $trip->status == 'created' || $trip->status == 'approved') {
                if ($request->after_3_minutes == 0) {

                    $trip->update([
                        'status' => 'cancelled',
                        'cancellation_reason' => $request->cancellation_reason

                    ]);

                    //Remove coupon 

                    $coupon = Coupon::where("id", $trip->coupon_id)->first();
                    if ($coupon) {
                        $coupon->decrement("current_count");
                        $user_coupon = CouponUser::where('coupon', $trip->coupon_id)->where('user', $trip->client_id)->first();
                        $user_coupon->delete();
                    }

                    return $this->returnSuccess("تم إلغاء الرحله بنجاح");
                } else {

                    $trip->update([
                        'status' => 'cancelled',
                        'cancellation_reason' => $request->cancellation_reason

                    ]);

                    // add discount iin customer wallet and remove value from his wallet
                    $customer_wallet = Wallet::where('customer_id', $customer->id)->first();
                    if (!$customer_wallet) {
                        $customer_wallet = Wallet::create([
                            'customer_id' => $customer->id,
                            'wallet_balance' => '0'
                        ]);
                    }
                    $discount_setting = DiscountSetting::where('name', 'customer')->first();
                    $customer_wallet->wallet_balance -= $discount_setting->discount_value;
                    $customer_wallet->save();
                    WalletHistoryGeneralHelper::addCustomerWalletHistory($discount_setting->discount_value, "Customer", "Minus", Auth::id(), $customer_wallet->id, $trip->id);

                    //add value from admin wallet 
                    $admin_wallet = AdminWallet::where('admin_id', 2)->first();
                    $admin_wallet->wallet_balance += $discount_setting->discount_value;
                    $admin_wallet->save();
                    WalletHistoryGeneralHelper::addAdminWalletHistory($discount_setting->discount_value, "APP", "Add", Auth::id(), $admin_wallet->id);

                    //Remove coupon 

                    $coupon = Coupon::where("id", $trip->coupon_id)->first();
                    if ($coupon) {
                        $coupon->decrement("current_count");
                        $user_coupon = CouponUser::where('coupon', $trip->coupon_id)->where('user', $trip->client_id)->first();
                        $user_coupon->delete();
                    }
                    return $this->returnSuccess("تم إلغاء الرحله بنجاح");
                }
            } else {
                return $this->returnError("لم يتم قبول هذه الرحله من قبل !");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }
    public function getFinishTrip(EndTripRequest $request)
    {

        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $trip = Trip::select('trips.cost', 'trips.cost_after_discount', 'trips.type_of_payment')
                ->where('trips.id', $request->trip_id)->first();
            if ($trip) {
                return $this->returnData([
                    'amount_before_discount' => number_format((float)$trip->cost, 2),
                    'required_amount' =>  number_format((float)$trip->cost_after_discount, 2),
                    'type_of_payment' => $trip->type_of_payment
                ], "تم إنهاء الرحله بنجاح");
            } else {
                return $this->returnError("لا يوجد رحله بهذا ال id !");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function waiting_trips(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $trips = Trip::select('customers.name as customer_name', 'drivers.fullname as driver_name', 'price_lists.name as price_list_name', 'trips.status', 'trips.created_at', 'trips.trip_approve_time', 'trips.trip_arrive_time', 'trips.trip_start_time', 'trips.start_lat', 'trips.start_long', 'trips.end_lat', 'trips.end_long', 'trips.trip_time', 'trips.distance', 'trips.cost')
                ->leftjoin('customers', 'customers.id', 'trips.client_id')
                ->leftjoin('drivers', 'drivers.id', 'trips.driver_id')
                ->leftjoin('price_lists', 'price_lists.id', 'trips.price_list_id')
                ->where('trips.client_id', $customer->id)
                ->whereIn('trips.status', ['created', 'approved', 'arrived'])
                ->get();
            return $this->returnData($trips, 'تم الحصول على الرحلات بنجاح ');
        } else {
            return $this->returnError("Unauthoried");
        }
        // $trips = Trip::where([['client_id',request()->user()->id],['status','waiting']])->get();

        // return $this->returnData(TripResource::collection($trips), "");
    }

    public function active_trips(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $trips = Trip::select('customers.name as customer_name', 'drivers.fullname as driver_name', 'price_lists.name as price_list_name', 'trips.status', 'trips.created_at', 'trips.trip_approve_time', 'trips.trip_arrive_time', 'trips.trip_start_time', 'trips.start_lat', 'trips.start_long', 'trips.end_lat', 'trips.end_long', 'trips.trip_time', 'trips.distance', 'trips.cost')
                ->leftjoin('customers', 'customers.id', 'trips.client_id')
                ->leftjoin('drivers', 'drivers.id', 'trips.driver_id')
                ->leftjoin('price_lists', 'price_lists.id', 'trips.price_list_id')
                ->where('trips.driver_id', $customer->id)
                ->where('trips.status', 'started')
                ->get();
            return $this->returnData($trips, 'تم الحصول على الرحلات بنجاح ');
        } else {
            return $this->returnError("Unauthoried");
        }
        // $trip = Trip::where([['client_id',request()->user()->id],['status','active']])->first();
        //     if(!$trip)
        //         return $this->returnError('لا يوجد رحله');

        // return $this->returnData(new TripResource($trip), "");
    }

    public function cancelled_trips()
    {

        $trips = Trip::where([['client_id', request()->user()->id], ['status', 'canceled']])->get();

        return $this->returnData(TripResource::collection($trips), "");
    }

    public function finished_trips(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $trips = Trip::select('customers.name as customer_name', 'drivers.fullname as driver_name', 'price_lists.name as price_list_name', 'trips.status', 'trips.created_at', 'trips.trip_approve_time', 'trips.trip_arrive_time', 'trips.trip_start_time', 'trips.start_lat', 'trips.start_long', 'trips.end_lat', 'trips.end_long', 'trips.trip_time', 'trips.distance', 'trips.cost')
                ->leftjoin('customers', 'customers.id', 'trips.client_id')
                ->leftjoin('drivers', 'drivers.id', 'trips.driver_id')
                ->leftjoin('price_lists', 'price_lists.id', 'trips.price_list_id')
                ->where('trips.driver_id', $customer->id)
                ->where('trips.status', 'finished')
                ->get();
            return $this->returnData($trips, 'تم الحصول على الرحلات بنجاح ');
        } else {
            return $this->returnError("Unauthoried");
        }
        // $trips = Trip::where([['client_id',request()->user()->id],['status','finished']])->get();

        // return $this->returnData(TripResource::collection($trips), "");
    }

    public function getTripDetails(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $trip = Trip::select('trips.driver_id', 'trips.start_lat', 'trips.start_long', 'trips.end_lat', 'trips.end_long', 'trips.type_of_payment')
                ->where('trips.id', $request->trip_id)
                ->first();
            $emergency = Emergency::where('type', 'from customer')->where('user_id', $customer->id)->where('trip_id', $request->trip_id)->first();
            if ($emergency) {
                $trip->emergency_mode = true;
            } else {
                $trip->emergency_mode = false;
            }
            if ($trip) {
                return $this->returnData($trip, 'تم الحصول على معلومات الرحله بنجاح');
            } else {
                return $this->returnError('لا يوجد رحلة الرجاء التأكد من هذا ال ID');
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function addDriverReview(AddDriverReviewRequest $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            if (DriverModel::find($request->driver_id)) {

                $review = DriverReview::create([
                    'rate'      => $request->rate,
                    'comment'   => $request->comment,
                    'driver_id' => $request->driver_id,
                    'customer_id' => $customer->id
                ]);
                return $this->returnData($review, 'تم اضافه الريفيو بنجاح');
            } else {
                return $this->returnError("لا يوجد سائق ب هذا ال ID");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }
    public function updatePaymentTypeOfTrip(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $trip = Trip::where('trips.id', $request->trip_id)->first();
            if ($trip) {
                $trip->update(['type_of_payment' => 1]);
                return $this->returnSuccess('تم التعديل بنجاح');
            } else {
                return $this->returnError('لا يوجد رحلة الرجاء التأكد من هذا ال ID');
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }
    public function getMyTrips(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {

            $trips = Trip::select(
                'drivers.id as driver_id',
                'drivers.fullname as driver_name',
                'drivers.phone',
                'drivers.image',
                'vehicles.vehicle_color',
                'vehicles.plate_number',
                'vehicles_markers.marker',
                'vehicles_models.model',
                // \DB::raw('FORMAT((SUM(driver_reviews.rate) / COUNT(driver_reviews.rate)),2) AS rate'),
                'price_lists.name as price_list_name',
                'trips.id as trip_id',
                'trips.status',
                'trips.created_at',
                'trips.start_lat',
                'trips.start_long',
                'trips.end_lat',
                'trips.end_long',
                'trips.trip_time',
                'trips.distance',
                'trips.cost'
            )
                ->leftjoin('drivers', 'drivers.id', 'trips.driver_id')
                ->leftjoin('price_lists', 'price_lists.id', 'trips.price_list_id')
                ->leftjoin('vehicles', 'vehicles.driver_id', 'drivers.id')
                ->leftjoin('vehicles_markers', 'vehicles_markers.id', 'vehicles.marker_id')
                ->leftjoin('vehicles_models', 'vehicles_models.id', 'vehicles.model_id')
                // ->leftjoin('driver_reviews', 'driver_reviews.driver_id', 'drivers.id')
                ->where('trips.client_id', $customer->id)
                ->where('trips.status', 'ended');

            switch ($request->filter) {
                case 1:
                    //---Today----

                    $trips->whereDate("trips.created_at", Carbon::today());
                    break;
                case 2:
                    //---This Week-----

                    $trips->whereBetween(
                        'trips.created_at',
                        [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]
                    );
                    break;

                case '3':

                    //---This Month-----
                    $trips->whereMonth('trips.created_at', Carbon::now()->month);

                    break;
            }

            $trips = $trips->get();
            foreach ($trips as $trip) {

                $rate = DriverReview::where('driver_id', $trip->driver_id)->sum('rate');
                if ($rate) {
                    $rate = $rate / DriverReview::where('driver_id', $trip->driver_id)->count();
                }
                $trip->driver_rate = number_format((float)$rate, 2);
            }
            return $this->returnData($trips, 'تم الحصول على الرحلات بنجاح');
        } else {
            return $this->returnError("Unauthoried");
        }
    }
    public function blockDriver(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $blockedDriver = BlockDrivers::where('customer_id', $customer->id)->where('driver_id', $request->driver_id)->first();
            if ($blockedDriver) {
                return $this->returnError("لقد قمت بإضافه هذا السائق فى لائحه الحظر من قبل ");
            } else {
                $blockDriver = BlockDrivers::create([
                    'customer_id' => $customer->id,
                    'driver_id' => $request->driver_id
                ]);
                return $this->returnSuccess('تم حظر السائق بنجاح');
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }
    public function getBlockDrivers(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $blockDrivers = BlockDrivers::where('customer_id', $customer->id)->get();

            if (count($blockDrivers) > 0) {
                $blockedDrivers = BlockDrivers::select(
                    'block_drivers.driver_id',
                    'block_drivers.created_at',
                    'drivers.fullname',
                    'drivers.image',
                    'vehicles.vehicle_color',
                    'vehicles.plate_number',
                    'vehicles_markers.marker',
                    'vehicles_models.model'
                    // \DB::raw('FORMAT((SUM(driver_reviews.rate) / COUNT(driver_reviews.rate)),2) AS rate')
                )
                    ->leftjoin('drivers', 'drivers.id', 'block_drivers.driver_id')
                    ->leftjoin('vehicles', 'vehicles.driver_id', 'drivers.id')
                    ->leftjoin('vehicles_markers', 'vehicles_markers.id', 'vehicles.marker_id')
                    // ->leftjoin('driver_reviews', 'driver_reviews.driver_id', 'drivers.id')
                    ->leftjoin('vehicles_models', 'vehicles_models.id', 'vehicles.model_id')
                    ->where('block_drivers.customer_id', $customer->id)
                    ->get();

                foreach ($blockedDrivers as $driver) {

                    $rate = DriverReview::where('driver_id', $driver->driver_id)->sum('rate');
                    if ($rate) {
                        $rate = $rate / DriverReview::where('driver_id', $driver->driver_id)->count();
                    }

                    $driver->rate = number_format((float)$rate, 2);
                }
                return $this->returnData($blockedDrivers, 'تم الحصول على الداتا بنجاح');
            } else {
                return $this->returnData([], 'تم الحصول على الداتا بنجاح');
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }
    public function unBlockDriver(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $blockedDriver = BlockDrivers::where('customer_id', $customer->id)->where('driver_id', $request->driver_id)->first();
            if ($blockedDriver) {
                $blockedDriver->delete();
                return $this->returnSuccess("تم فك الحظر بنجاح");
            } else {

                return $this->returnError('هذا السائق لم يتم حظره من قبل!');
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }
    public function addDriverToFav(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $favDriver = FavoriteDrivers::where('customer_id', $customer->id)->where('driver_id', $request->driver_id)->first();
            if ($favDriver) {
                return $this->returnError("لقد قمت بإضافه هذا السائق فى لائحه المفضلة من قبل ");
            } else {
                FavoriteDrivers::create([
                    'customer_id' => $customer->id,
                    'driver_id' => $request->driver_id
                ]);
                return $this->returnSuccess('تم اضافه السائق بنجاح');
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }
    public function getFavDrivers(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $favDrivers = FavoriteDrivers::where('customer_id', $customer->id)->get();

            if (count($favDrivers) > 0) {

                $favDrivers = FavoriteDrivers::select(
                    'favorite_drivers.driver_id',
                    'favorite_drivers.created_at',
                    'drivers.fullname',
                    'drivers.image',
                    'vehicles.vehicle_color',
                    'vehicles.plate_number',
                    'vehicles_markers.marker',
                    'vehicles_models.model'
                    // \DB::raw('FORMAT((SUM(driver_reviews.rate) / COUNT(driver_reviews.rate)),2) AS rate')
                )
                    ->leftjoin('drivers', 'drivers.id', 'favorite_drivers.driver_id')
                    ->leftjoin('vehicles', 'vehicles.driver_id', 'drivers.id')
                    ->leftjoin('vehicles_markers', 'vehicles_markers.id', 'vehicles.marker_id')
                    ->leftjoin('vehicles_models', 'vehicles_models.id', 'vehicles.model_id')
                    // ->leftjoin('driver_reviews', 'driver_reviews.driver_id', 'drivers.id')
                    ->where('favorite_drivers.customer_id', $customer->id)->get();
                foreach ($favDrivers as $driver) {

                    $rate = DriverReview::where('driver_id', $driver->driver_id)->sum('rate');
                    if ($rate) {
                        $rate = $rate / DriverReview::where('driver_id', $driver->driver_id)->count();
                    }

                    $driver->rate = number_format((float)$rate, 2);
                }


                return $this->returnData($favDrivers, 'تم الحصول على الداتا بنجاح');
            } else {
                return $this->returnData([], 'تم الحصول على الداتا بنجاح');
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }
    public function removeDriverFromFav(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $favDriver = FavoriteDrivers::where('customer_id', $customer->id)->where('driver_id', $request->driver_id)->first();
            if ($favDriver) {
                $favDriver->delete();
                return $this->returnSuccess("تم مسح السائق من المفضلة بنجاح");
            } else {

                return $this->returnError('هذا السائق لم يتم اضافته فى المفضلة من قبل!');
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    //----check coupon -----
    public function checkCoupon(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $coupon = Coupon::where("name", $request->coupon)->where(function ($query) {
                $query->where("max_count", null)->orWhere("max_count", ">", "current_count");
            })->where(function ($query) {
                $query->where("expire_date", null)->orWhere("expire_date", ">=", Carbon::today());
            })->first();
            if ($coupon) {
                $used = CouponUser::where("coupon", $coupon->id)->where("user", $customer->id)->first();
                if ($used) {
                    return $this->returnError("استخدمت الكود ده قبل كده");
                } else {
                    $type = $coupon->type;
                    $value = null;
                    if ($type == 1) {
                        $value = $coupon->value;
                    } else if ($type == 2) {
                        $value = $coupon->percentage;
                    }
                    return $this->returnData(["id" => $coupon->id, "value" => $value, "type" => $type], "الكوبون صالح");
                }
            } else {
                return $this->returnError("الكوبون مش موجود او انتهت صلاحيته");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    //----remove coupon -----
    public function removeCoupon(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $coupon = CouponUser::where("coupon", $request->coupon_id)->where('user', $customer->id)->first();
            if ($coupon) {
                $coupon->delete();
                return $this->returnData([], "تم المسح بنجاح");
            } else {
                return $this->returnError(" كود غير موجود");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }
}
