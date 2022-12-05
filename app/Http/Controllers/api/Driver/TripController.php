<?php

namespace App\Http\Controllers\api\Driver;

use App\CustomerContact;
use App\Events\OrderAcceptedEvent;
use App\Group;
use App\GroupMember;
use App\Http\Controllers\Controller;
use App\Models\admin\DriverModel;
use App\Models\shop\Order;
use App\traits\FCMTrait;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use Carbon\Carbon;
use App\Http\Resources\OrderResource;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use App\Helpers\GeneralHelper;
use App\Http\Requests\Trip\CancelTripRequest;
use App\Http\Requests\Trip\CustomerPaidAmountRequest;
use App\Http\Requests\Trip\FinishTripRequest;
use App\Models\admin\DiscountSetting;
use App\Models\admin\PriceList;
use App\Models\DriverWallet;
use App\Models\DriverWalletHistory;
use App\Models\Wallet;
use App\WalletHistory;
use App\Helpers\WalletHistoryGeneralHelper;
use App\Http\Requests\Trip\EndTripRequest;
use App\Models\AdminWallet;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\Emergency;
use App\Models\PayForMeHistory;
use App\SharedWalletContact;
use App\SharedWalletHistory;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    use ResonseTrait;
    use FCMTrait;

    public function approveTrip(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {

            $trip = Trip::where('id', $request->trip_id)->first();
            if ($trip && $trip->status == 'created') {

                $trip->update([
                    'status' => 'approved',
                    'trip_approve_time' =>  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now()),
                    'driver_id' => $driver->id
                ]);

                return $this->returnSuccess("تم قبول الرحله بنجاح");
            } else {
                return $this->returnError("تم قبول هذه الرحلة من قِبل سائق أخر");
            }
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function arriveTrip(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {

            $trip = Trip::where('id', $request->trip_id)->where('driver_id', $driver->id)->first();
            if ($trip && $trip->status == 'approved') {

                $trip->update([
                    'status' => 'arrived',
                    'trip_arrive_time' =>  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now())

                ]);

                return $this->returnSuccess("لقد وصلت الى الراكب بنجاح");
            } else {
                return $this->returnError("لا يمكنك الوصول ل هذه الرحله !");
            }
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function cancelTrip(CancelTripRequest $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {

            $trip = Trip::where('id', $request->trip_id)->where('driver_id', $driver->id)->first();
            if ($trip) {
                if ($trip->status == 'approved') {
                    if ($request->after_3_minutes == 0) {
                        $trip->update([
                            'status' => 'cancelled_from_driver',
                            'cancellation_reason' => $request->cancellation_reason
                        ]);

                        //Remove coupon 

                        $coupon = Coupon::where("id", $trip->coupon_id)->first();
                        if ($coupon) {
                            $coupon->decrement("current_count");
                            $user_coupon = CouponUser::where('coupon', $trip->coupon_id)->where('user', $trip->client_id)->first();
                            $user_coupon->delete();
                        }
                        return $this->returnSuccess("تم الغاء الرحله بنجاح");
                    } else {
                        // add discount in Driver wallet and remove value from his wallet

                        $wallet = DriverWallet::where('driver_id', $driver->id)->first();

                        $discount_setting = DiscountSetting::where('name', 'driver')->first();

                        $wallet->wallet_balance -= $discount_setting->discount_value;
                        $wallet->save();
                        WalletHistoryGeneralHelper::addDriverWalletHistory($discount_setting->discount_value, "Driver", "Minus", $driver->id, $wallet->id, $trip->id);

                        //add value from admin wallet 
                        $admin_wallet = AdminWallet::where('admin_id', 2)->first();
                        $admin_wallet->wallet_balance += $discount_setting->discount_value;
                        $admin_wallet->save();
                        WalletHistoryGeneralHelper::addAdminWalletHistory($discount_setting->discount_value, "APP", "Add", Auth::id(), $admin_wallet->id);
                        $trip->update([
                            'status' => 'cancelled_from_driver',
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
                    }
                } else if ($trip->status == 'arrived') {
                    if ($request->after_3_minutes == 1) {
                        // add discount in Driver wallet and remove value from his wallet

                        $wallet = DriverWallet::where('driver_id', $driver->id)->first();
                        if ($wallet) {
                            $discount_setting = DiscountSetting::where('name', 'driver')->first();

                            $wallet->wallet_balance -= $discount_setting->discount_value;
                            $wallet->save();
                            WalletHistoryGeneralHelper::addDriverWalletHistory($discount_setting->discount_value, "Driver", "Minus", $driver->id, $wallet->id, $trip->id);

                            //add value from admin wallet 
                            $admin_wallet = AdminWallet::where('admin_id', 2)->first();
                            $admin_wallet->wallet_balance += $discount_setting->discount_value;
                            $admin_wallet->save();
                            WalletHistoryGeneralHelper::addAdminWalletHistory($discount_setting->discount_value, "APP", "Add", Auth::id(), $admin_wallet->id);
                            $trip->update([
                                'status' => 'cancelled_from_driver',
                                'cancellation_reason' => $request->cancellation_reason
                            ]);

                            //Remove coupon 

                            $coupon = Coupon::where("id", $trip->coupon_id)->first();
                            if ($coupon) {
                                $coupon->decrement("current_count");
                                $user_coupon = CouponUser::where('coupon', $trip->coupon_id)->where('user', $trip->client_id)->first();
                                $user_coupon->delete();
                            }
                            return $this->returnSuccess("تم الغاء الرحله بنجاح");
                        } else {
                            $trip->update([
                                'status' => 'cancelled_from_driver',
                                'cancellation_reason' => $request->cancellation_reason
                            ]);

                            //Remove coupon 

                            $coupon = Coupon::where("id", $trip->coupon_id)->first();
                            if ($coupon) {
                                $coupon->decrement("current_count");
                                $user_coupon = CouponUser::where('coupon', $trip->coupon_id)->where('user', $trip->client_id)->first();
                                $user_coupon->delete();
                            }
                            return $this->returnSuccess("تم الغاء الرحله بنجاح");
                        }
                    }
                } else {
                    return $this->returnError("لا يمكنك الغاء الرحله الان!");
                }
            } else {
                return $this->returnError("لم يتم قبول هذه الرحله من قبل !");
            }
        } else {
            return $this->returnError("UnAuthorized");
        }
    }
    public function startTrip(Request $request)
    {

        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {

            $trip = Trip::where('id', $request->trip_id)->where('driver_id', $driver->id)->first();
            if ($trip && $trip->status == 'arrived') {

                $trip->update([
                    'status' => 'started',
                    'trip_start_time' =>  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now())

                ]);

                return $this->returnSuccess("تم بدء الرحله بنجاح");
            } else {
                return $this->returnError("لا يمكنك بدء هذه الرحله الان !");
            }
        } else {
            return $this->returnError("UnAuthorized");
        }
    }
    public function finishTrip(FinishTripRequest $request)
    {

        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $trip = Trip::select('trips.*')
                ->where('trips.id', $request->trip_id)
                ->where('trips.driver_id', $driver->id)
                ->first();
            if ($trip && $trip->status == 'started') {
                $price_list = PriceList::where('id', $trip->price_list_id)->first();

                $kilo_price = $price_list->kilo_price;
                $minute_price = $price_list->minute_price;
                $start_price = $price_list->start_price;

                $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $trip->trip_start_time);
                $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now());
                $time_in_minutes = $from->diffInMinutes($to);

                $distance =  floatval($request->distance);
                // ---- total cost before coupon or wallet
                $total_before_discount = ($distance * $kilo_price) + ($time_in_minutes * $minute_price) +  $start_price;

                if ($trip->coupon_id != NULL) {
                    $coupon = Coupon::where("id", $trip->coupon_id)->first();
                    $type = $coupon->type;
                    //---coupon value is amount 
                    if ($type == 1) {
                        //---total after coupon discount
                        $total_cost_after_coupon = $total_before_discount - $coupon->value;
                        //---- coupon value greater than cost
                        if ($total_cost_after_coupon <= 0) {
                            $total_cost_after_coupon = 0;
                        } else {
                            $total_cost_after_coupon = $total_cost_after_coupon;
                        }
                        // coupon value is percentage
                    } else if ($type == 2) {
                        $discount_value = ($coupon->percentage / 100) * $total_before_discount;
                        $total_cost_after_coupon = $total_before_discount - $discount_value;
                    }
                    $trip->update([
                        'cost' => number_format($total_cost_after_coupon, 2),
                        'status' => 'finished',
                        'trip_end_time' =>  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now()),
                        'trip_time' => $time_in_minutes,
                        'distance' => $request->distance
                    ]);
                } else {

                    $trip->update([
                        'cost' => number_format($total_before_discount, 2),
                        'status' => 'finished',
                        'trip_end_time' =>  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now()),
                        'trip_time' => $time_in_minutes,
                        'distance' => $request->distance
                    ]);
                }

                //check if payment is pay for me
                if ($trip->type_of_payment == 3) {

                    $cost_required = $this->payForMe($trip);
                } else {
                    //----check Customer Wallet to return Cost to Driver ----
                    $cost_required = $this->checkCustomerWallet($trip->client_id, $trip->driver_id, $trip);
                }

                $trip->cost_after_discount = number_format($cost_required, 2);
                $trip->save();

                return $this->returnData([
                    'amount_before_discount' => number_format($total_before_discount, 2),
                    'required_amount' =>  number_format($cost_required, 2),
                    'type_of_payment' => $trip->type_of_payment
                ], "تم إنهاء الرحله بنجاح");
            } else {
                return $this->returnError("لا يمكنك انهاء هذه الرحله الان !");
            }
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function checkCustomerWallet($customer_id, $driver_id, $trip)
    {
        $customer_wallet = Wallet::select('wallets.*')->where('customer_id', $customer_id)->first();
        $driver_wallet = DriverWallet::select('driver_wallets.*')->where('driver_id', $driver_id)->first();
        $cost = number_format((float)$trip->cost, 2);
        $wallet_balance = $customer_wallet->wallet_balance;
        // if customer wallet greater than 0 
        if ($wallet_balance > 0) {
            //first case wallet have value greater than cost
            if ($wallet_balance >= $cost) {
                //--remove cost value from customer wallet
                // $value = $wallet_balance - $cost;
                $wallet_balance -= $cost;
                $customer_wallet->wallet_balance = $wallet_balance;
                $customer_wallet->save();

                //----create customer wallet History
                WalletHistoryGeneralHelper::addCustomerWalletHistory($cost, "Customer", "Minus", $trip->client_id, $customer_wallet->id, $trip->id);

                //----add cost value to driver wallet
                $driver_wallet->wallet_balance += $cost;
                $driver_wallet->save();
                //---create driver wallet history
                WalletHistoryGeneralHelper::addDriverWalletHistory($cost, "Driver", "Add", $driver_id, $driver_wallet->id, $trip->id);

                $cost = 0;

                //case 2 when cost value greater than wallet ballance
            } else if ($cost > $wallet_balance) {
                //remove cost value from customer wallet
                $reset = $cost - $wallet_balance;

                $customer_wallet->wallet_balance = 0;
                $customer_wallet->save();
                //--add to customer history
                WalletHistoryGeneralHelper::addCustomerWalletHistory($reset, "Customer", "Minus", $trip->client_id, $customer_wallet->id, $trip->id);

                //add cost value to driver wallet 
                $driver_wallet->wallet_balance += $wallet_balance;
                $driver_wallet->save();
                //---create driver wallet history
                WalletHistoryGeneralHelper::addDriverWalletHistory($reset, "Driver", "Add", $driver_id, $driver_wallet->id, $trip->id);
                //-----take reset from shared wallet`  
                if ($trip->type_of_payment == 4) {
                    $cost = $this->sharedWallet($trip, $reset);
                    // dd("check wallet ", $cost);
                } else {
                    $cost = $reset;
                }
            }
        } else if ($trip->type_of_payment == 4 && ($wallet_balance <= 0  || $wallet_balance == 0.0)) {
            $cost = $this->sharedWallet($trip, $cost);
            // return $cost;
        }

        return $cost;
    }

    public function payForMe($trip)
    {
        $pay_history  = PayForMeHistory::select('pay_for_me_histories.*', 'customer_contacts.customer_id', 'customer_contacts.contact_id')
            ->leftjoin('customer_contacts', 'customer_contacts.id', 'pay_for_me_histories.contact_id')
            ->where('trip_id', $trip->id)->first();
        $driver_wallet = DriverWallet::select('driver_wallets.*')->where('driver_id', $trip->driver_id)->first();

        $cost = number_format((float)$trip->cost, 2);

        if ($pay_history->status == "Accepted") {
            $wallet_contact = Wallet::select('id', 'customer_id', 'wallet_balance')->where('customer_id', $pay_history->contact_id)->first();
            $wallet_balance = $wallet_contact->wallet_balance;

            // if customer wallet greater than 0 
            if ($wallet_balance > 0) {
                //first case wallet have value greater than cost
                if ($wallet_balance >= $cost) {
                    //--remove cost value from customer wallet
                    // $value = $wallet_balance - $cost;
                    $wallet_balance -= $cost;
                    $wallet_contact->wallet_balance = $wallet_balance;
                    $wallet_contact->save();

                    //----create customer wallet History
                    WalletHistoryGeneralHelper::addCustomerWalletHistory($cost, "Customer", "Minus", $wallet_contact->customer_id, $wallet_contact->id, $trip->id);

                    //----add cost value to driver wallet
                    $driver_wallet->wallet_balance += $cost;
                    $driver_wallet->save();
                    //---create driver wallet history
                    WalletHistoryGeneralHelper::addDriverWalletHistory($cost, "Driver", "Add", $trip->driver_id, $driver_wallet->id, $trip->id);
                    $cost = 0;


                    //case 2 when cost value greater than wallet ballance
                } else if ($cost > $wallet_balance) {
                    //remove cost value from customer wallet
                    $reset = $cost - $wallet_balance;

                    $wallet_contact->wallet_balance = 0;
                    $wallet_contact->save();
                    // dd( $cost , $reset  ,$wallet_contact);
                    //--add to customer history
                    WalletHistoryGeneralHelper::addCustomerWalletHistory($reset, "Customer", "Minus", $wallet_contact->customer_id, $wallet_contact->id, $trip->id);

                    //add cost value to driver wallet 
                    $driver_wallet->wallet_balance += $wallet_balance;
                    $driver_wallet->save();
                    //---create driver wallet history
                    WalletHistoryGeneralHelper::addDriverWalletHistory($reset, "Driver", "Add", $trip->driver_id, $driver_wallet->id, $trip->id);

                    $cost = $reset;
                }
            }

            return $cost;
        }
    }

    public function sharedWallet($trip, $reset)
    {
        $shared_contact = $this->checkCustomer($trip);
        $contact_wallet = $shared_contact['contact_wallet'];
        $customer_id = $shared_contact['customer_id'];
        $driver_wallet = DriverWallet::select('driver_wallets.*')->where('driver_id', $trip->driver_id)->first();
        $cost = number_format((float)$reset, 2);
        $wallet_contact = Wallet::select('id', 'customer_id', 'wallet_balance')->where('customer_id', $customer_id)->first();
        if ($wallet_contact->wallet_balance <= '0') {
            $reset = $cost;
        } else {

            // shared wallet with limit value
            if ($contact_wallet->limit == 1) {
                // if trip cost less than limit value 
                if ($cost < $contact_wallet->limit_value) { //9 < 10

                    $check = $wallet_contact->wallet_balance - $cost;  // 1 -9 =-8
                    if ($check <= '0') {
                        $reset = $cost - $wallet_contact->wallet_balance; // 9-1 = 8

                        $contact_wallet->limit_value -= $wallet_contact->wallet_balance; // 10 - 1 = 9
                        $contact_wallet->save();
                       

                        //----create customer wallet History
                        WalletHistoryGeneralHelper::addCustomerWalletHistory($wallet_contact->wallet_balance, "Customer", "Minus", $wallet_contact->customer_id, $wallet_contact->id, $trip->id);

                        //----add cost value to driver wallet
                        $driver_wallet->wallet_balance += $wallet_contact->wallet_balance;
                        $driver_wallet->save();
                        //---create driver wallet history
                        WalletHistoryGeneralHelper::addDriverWalletHistory($wallet_contact->wallet_balance, "Driver", "Add", $trip->driver_id, $driver_wallet->id, $trip->id);


                        $wallet_contact->wallet_balance = 0;
                        $wallet_contact->save();

                    } else {
                        //check > 0
                        // $reset = $wallet_contact->wallet_balance - $cost; // 10 -9 =1
                        $reset =0;
                        $wallet_contact->wallet_balance = $wallet_contact->wallet_balance - $cost;  

                        $contact_wallet->limit_value -= $cost; // 10 - 9 = 1 
                        $contact_wallet->save();
                        $wallet_contact->save();

                        //----create customer wallet History
                        WalletHistoryGeneralHelper::addCustomerWalletHistory($cost, "Customer", "Minus", $wallet_contact->customer_id, $wallet_contact->id, $trip->id);

                        //----add cost value to driver wallet
                        $driver_wallet->wallet_balance += $cost;
                        $driver_wallet->save();
                        //---create driver wallet history
                        WalletHistoryGeneralHelper::addDriverWalletHistory($cost, "Driver", "Add", $trip->driver_id, $driver_wallet->id, $trip->id);
                    }


                    // if trip cost greater than limit value
                } elseif ($cost > $contact_wallet->limit_value) { //15 > 10

                    $check = $wallet_contact->wallet_balance - $cost;
                    if ($check <= '0') {
                        //balance = 0
                        $reset = $cost - $wallet_contact->wallet_balance; // 9-1 = 8

                        $contact_wallet->limit_value -= $wallet_contact->wallet_balance; // 10 - 1 = 9
                        $contact_wallet->save();

                        //----create customer wallet History
                        WalletHistoryGeneralHelper::addCustomerWalletHistory($wallet_contact->wallet_balance, "Customer", "Minus", $wallet_contact->customer_id, $wallet_contact->id, $trip->id);

                        //----add cost value to driver wallet
                        $driver_wallet->wallet_balance += $wallet_contact->wallet_balance;
                        $driver_wallet->save();
                        //---create driver wallet history
                        WalletHistoryGeneralHelper::addDriverWalletHistory($wallet_contact->wallet_balance, "Driver", "Add", $trip->driver_id, $driver_wallet->id, $trip->id);


                        $wallet_contact->wallet_balance = 0;
                        $wallet_contact->save();
                    } else {
                        //balance = 20

                        //check > 0   , balance - cost = 20-15 = 5

                        // wallet balance = 20 , cost =15 , limit value = 10
                        // limit = 0 , walat balance = balance - limit vlaue = 20 - 10 = 10 , reset = cost - limit = 15-10 = 5

                        $wallet_contact->wallet_balance -= $contact_wallet->limit_value; // 20 - 10 = 10
                        $wallet_contact->save();

                        $reset = $cost - $contact_wallet->limit_value; // 15 - 10 = 5


                        //----create customer wallet History
                        WalletHistoryGeneralHelper::addCustomerWalletHistory($contact_wallet->limit_value, "Customer", "Minus", $wallet_contact->customer_id, $wallet_contact->id, $trip->id);

                        //----add cost value to driver wallet
                        $driver_wallet->wallet_balance += $contact_wallet->limit_value;
                        $driver_wallet->save();
                        //---create driver wallet history
                        WalletHistoryGeneralHelper::addDriverWalletHistory($contact_wallet->limit_value, "Driver", "Add", $trip->driver_id, $driver_wallet->id, $trip->id);


                        $contact_wallet->limit_value = 0;
                        $contact_wallet->save();
                    }
                }
            } else {
                $wallet_balance = $wallet_contact->wallet_balance;
                if ($wallet_balance > 0) {
                    //first case wallet have value greater than cost
                    if ($wallet_balance >= $cost) {
                        //--remove cost value from customer wallet
                        // $value = $wallet_balance - $cost;
                        $wallet_balance -= $cost;
                        $wallet_contact->wallet_balance = $wallet_balance;
                        $wallet_contact->save();

                        //----create customer wallet History
                        WalletHistoryGeneralHelper::addCustomerWalletHistory($cost, "Customer", "Minus", $wallet_contact->customer_id, $wallet_contact->id, $trip->id);

                        //----add cost value to driver wallet
                        $driver_wallet->wallet_balance += $cost;
                        $driver_wallet->save();
                        //---create driver wallet history
                        WalletHistoryGeneralHelper::addDriverWalletHistory($cost, "Driver", "Add", $trip->driver_id, $driver_wallet->id, $trip->id);
                        $reset = 0;


                        //case 2 when cost value greater than wallet ballance
                    } else if ($cost > $wallet_balance) {
                        //remove cost value from customer wallet
                        $reset = $cost - $wallet_balance;

                        $wallet_contact->wallet_balance = 0;
                        $wallet_contact->save();
                        // dd( $cost , $reset  ,$wallet_contact);
                        //--add to customer history
                        WalletHistoryGeneralHelper::addCustomerWalletHistory($reset, "Customer", "Minus", $wallet_contact->customer_id, $wallet_contact->id, $trip->id);

                        //add cost value to driver wallet 
                        $driver_wallet->wallet_balance += $wallet_balance;
                        $driver_wallet->save();
                        //---create driver wallet history
                        WalletHistoryGeneralHelper::addDriverWalletHistory($reset, "Driver", "Add", $trip->driver_id, $driver_wallet->id, $trip->id);
                    }
                }
            }
        }

        // dd($reset);

        return $reset;
    }


    public function checkCustomer($trip)
    {
        $shared_wallet = SharedWalletHistory::where('trip_id', $trip->id)->first();
        if ($shared_wallet->type == 'member') {
            $shared_contact = SharedWalletContact::where('customer_contact_id', $shared_wallet->customer_contact_id)->first();
            $contact = CustomerContact::where('id', $shared_contact->customer_contact_id)->first();
            // $shared_contact->customer = $contact->customer_id;
        } else if ($shared_wallet->type == 'group') {
            $shared_contact = GroupMember::where('customer_contact_id', $shared_wallet->customer_contact_id)->first();
            $contact = Group::where('id', $shared_contact->group_id)->first();
            // $shared_contact->customer = $contact->customer_id;
        }
        return ['contact_wallet' => $shared_contact, 'customer_id' => $contact->customer_id];
    }

    public function endTrip(EndTripRequest $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $trip = Trip::where('id', $request->trip_id)->where('driver_id', $driver->id)->first();
            if ($trip && $trip->status == 'finished') {
                $trip->update([

                    'status' => 'ended',

                ]);
                return $this->returnSuccess("تم انهاء الرحله بنجاح");
            } else {
                return $this->returnError("لا يمكنك انهاء هذه الرحله الان !");
            }
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function customerPaidAmount(CustomerPaidAmountRequest $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        $required_amount = number_format($request->required_amount, 2);
        $paid_amount = number_format($request->paid_amount, 2);
        if ($driver) {
            $trip = Trip::select('id', 'client_id', 'cost')->where('id', $request->trip_id)->first();
            $customer_wallet = Wallet::select('wallets.*')->where('customer_id', $trip->client_id)->first();
            $driver_wallet = DriverWallet::select('driver_wallets.*')->where('driver_id', $driver->id)->first();
            $admin_wallet = AdminWallet::where('admin_id', 2)->first();

            if ($paid_amount > $required_amount) {
                $reset = $paid_amount - $required_amount;
                //-------Driver Wallet balance and add to  History
                $driver_wallet->wallet_balance -= $reset;
                $driver_wallet->save();

                WalletHistoryGeneralHelper::addDriverWalletHistory($reset, "Driver", "Minus", $driver->id, $driver_wallet->id, $trip->id);

                //-------Customer Wallet balance and add to  History

                $customer_wallet->wallet_balance += $reset;
                $customer_wallet->save();

                WalletHistoryGeneralHelper::addCustomerWalletHistory($reset, "Customer", "Add", $trip->client_id, $customer_wallet->id, $trip->id);
            } else {
                $reset = $required_amount - $paid_amount;
                //-------Driver Wallet balance and add to  History
                $driver_wallet->wallet_balance += $reset;
                $driver_wallet->save();

                WalletHistoryGeneralHelper::addDriverWalletHistory($reset, "Driver", "Minus", $driver->id, $driver_wallet->id, $trip->id);

                //-------Customer Wallet balance and add to  History

                $customer_wallet->wallet_balance -= $reset;
                $customer_wallet->save();

                WalletHistoryGeneralHelper::addCustomerWalletHistory($reset, "Customer", "Add", $trip->client_id, $customer_wallet->id, $trip->id);
                ///----Remove reset in admin wallet
                $admin_wallet->wallet_balance -= $reset;
                $admin_wallet->save();
                WalletHistoryGeneralHelper::addAdminWalletHistory($reset, "APP", "Minus", Auth::id(), $admin_wallet->id);
            }
            return $this->returnSuccess("تم الدفع بنجاح");
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function inProgresTrips(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $trips = Trip::select('customers.name as customer_name', 'drivers.fullname as driver_name', 'price_lists.name as price_list_name', 'trips.status', 'trips.created_at', 'trips.trip_approve_time', 'trips.trip_arrive_time', 'trips.trip_start_time', 'trips.start_lat', 'trips.start_long', 'trips.end_lat', 'trips.end_long', 'trips.trip_time', 'trips.distance', 'trips.cost')
                ->leftjoin('customers', 'customers.id', 'trips.client_id')
                ->leftjoin('drivers', 'drivers.id', 'trips.driver_id')
                ->leftjoin('price_lists', 'price_lists.id', 'trips.price_list_id')
                ->where('trips.driver_id', $driver->id)
                ->whereIn('trips.status', ['approved', 'arrived', 'started'])
                ->get();
            return $this->returnData($trips, 'تم الحصول على الرحلات بنجاح ');
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function finishedTrips(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $trips = Trip::select('customers.name as customer_name', 'drivers.fullname as driver_name', 'price_lists.name as price_list_name', 'trips.status', 'trips.created_at', 'trips.trip_approve_time', 'trips.trip_arrive_time', 'trips.trip_start_time', 'trips.trip_end_time', 'trips.start_lat', 'trips.start_long', 'trips.end_lat', 'trips.end_long', 'trips.trip_time', 'trips.distance', 'trips.cost')
                ->leftjoin('customers', 'customers.id', 'trips.client_id')
                ->leftjoin('drivers', 'drivers.id', 'trips.driver_id')
                ->leftjoin('price_lists', 'price_lists.id', 'trips.price_list_id')
                ->where('trips.driver_id', $driver->id)
                ->whereIn('trips.status', ['finished'])
                ->get();
            return $this->returnData($trips, 'تم الحصول على الرحلات المنتهية بنجاح ');
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function avalible_trips(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $trips = Trip::where('driver_id', $driver->id)->whereIn('status', ['approved', 'arrived', 'started'])->get();
            return $this->returnData(TripResource::collection($trips), "");
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function cancelled_trips(Request $request)
    {

        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $trips = Trip::where([['status', 'canceled'], ['driver_id', $driver->id]])->get();

            return $this->returnData(TripResource::collection($trips), "");
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function finished_trips(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {

            $trips = Trip::where([['status', 'finished'], ['driver_id', $driver->id]])->get();

            return $this->returnData(TripResource::collection($trips), "");
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function active_trip(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {

            $trip = Trip::where('driver_id', $driver->id)->whereIn('status', ['approved', 'arrived', 'started'])->first();
            if (!$trip)
                return $this->returnError('لا يوجد رحله');

            return $this->returnData(new TripResource($trip), "");
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function getTripDetails(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $trip = Trip::select('trips.client_id', 'trips.start_lat', 'trips.start_long', 'trips.end_lat', 'trips.end_long', 'trips.type_of_payment', 'customers.name', 'customers.phone', 'customers.image')
                ->where('trips.id', $request->trip_id)
                ->leftjoin('customers', 'customers.id', 'trips.client_id')
                ->first();
            $emergency = Emergency::where('type', 'from driver')->where('user_id', $driver->id)->where('trip_id', $request->trip_id)->first();
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
            return $this->returnError("UnAuthorized");
        }
    }
    public function getTripCost(Request $request)
    {

        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $trip = Trip::select('trips.cost', 'trips.cost_after_discount', 'trips.type_of_payment')
                ->where('trips.id', $request->trip_id)->first();
            if ($trip) {
                return $this->returnData([
                    'amount_before_discount' => number_format($trip->cost, 2),
                    'required_amount' =>  number_format($trip->cost_after_discount, 2),
                    'type_of_payment' => $trip->type_of_payment
                ], "تم إنهاء الرحله بنجاح");
            } else {
                return $this->returnError("لا يوجد رحله بهذا ال id !");
            }
        } else {
            return $this->returnError("Unauthoried");
        }
    }
}
