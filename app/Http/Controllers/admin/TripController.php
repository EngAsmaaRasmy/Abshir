<?php

namespace App\Http\Controllers\admin;

use App\Helpers\WalletHistoryGeneralHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Trip\CancelTripRequest;
use App\Http\Requests\Trip\FinishTripRequest;
use App\Models\Customer;
use App\Models\Trip;
use Illuminate\Http\Request;
use App\Http\Requests\Trip\MakeTripRequest;
use App\Models\admin\DriverModel;
use App\Models\admin\PriceList;
use App\Models\DriverWallet;
use App\Models\Wallet;
use App\traits\ResonseTrait;
use App\traits\FCMTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class TripController extends Controller
{
    use ResonseTrait;
    use FCMTrait;

    function __construct()
    {
         $this->middleware('permission:عرض الرحلات', ['only' => ['index', 'getTrips']]);
         $this->middleware('permission:عرض رحلة', ['only' => ['show']]);
         $this->middleware('permission:إضافة رحلة', ['only' => ['create','store']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.trips.index");
    }
    public function getTrips($status)
    {
        $trips = Trip::with(['driverRel', 'customerRel', 'priceList'])
        ->where('status', $status)
        ->orderBy('id', 'DESC')
        ->paginate(20);
        return $this->returnData($trips,"");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trip = Trip::find($id);
        return view("admin.trips.show", compact('trip'));
    }

    public function create()
    {
        $customers = Customer::select('id', 'name', 'phone')->get();
        $customer = Customer::latest()->first();
        return view('admin.trips.add', compact('customers', 'customer'));
    }

    public function addCustomer(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'phone' => 'required|min:10',
            'active' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->returnError($validator->errors()->first());
        }
        $phone = ('+20' . $request->input('phone'));
        $customer = Customer::create([
            'name' => $request->input('name'),
            'phone' => $phone,
            "api_token" => Str::random(60),
            'active' => $request->input('active'),
        ]);
        $request->session()->flash('message', '  تم إضافة عميل جديد بنجاح');
        $request->session()->flash('message-type', 'success');
        return response(["data"=> $customer]);
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'clint_id' => 'required',
            'price_list_id' => 'required',
            'start_lat' => 'required',
            'start_long' => 'required',
            'end_lat' => 'required',
            'end_long' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->returnError($validator->errors()->first());
        }
        $trip = Trip::create([
            'client_id' => $request->input('clint_id'),
            'price_list_id' => $request->input('price_list_id'),
            'start_lat' => $request->input('start_lat'),
            'start_long' => $request->input('start_long'),
            'end_lat' => $request->input('end_lat'),
            'end_long' => $request->input('end_long'),
            'status' =>'created',
        ]);
        $request->session()->flash('message', '  تم إضافة قائمةأسعار جديدة بنجاح');
        $request->session()->flash('message-type', 'success');
        return response(["data"=> $trip]);
    }
    public function sendNotification($id, $tripId)
    {
        try {
            $driver = DriverModel::query()->findOrFail($id);
            if ($driver) {
                $fcm = $this->sendToDriver($driver->fcm_token, "  رحلة جديدة", ' يوجد رحلة جديدة   ', $tripId);
                if ($fcm->status() == 200) {
                    return $this->returnSuccess('  تم إرسال الإشعار بنجاح ');
                }
                return redirect()->back();
            }
        } catch (\Throwable $e) {
            return $this->returnError('لم يتم إرسال الإشعار   ');
        }
    }

    public function cancelTrip(Request $request)
    {
        $trip = Trip::where('id', $request->trip_id)->first();
        if ($trip) {
            $trip->update([
                'status' => 'cancelled',
                'cancellation_reason'=>$request->cancellation_reason
            ]);
            return $this->returnSuccess("تم الغاء الرحله بنجاح");

        } else {
            return $this->returnError("لم يتم قبول هذه الرحله من قبل !");
        }
    }

    
    public function finishTrip(FinishTripRequest $request)
    { 
        $trip = Trip::where('id', $request->trip_id)->first();
        if ($trip && $trip->status == 'started') {
            $price_list = PriceList::where('id', $trip->price_list_id)->first();
            $kilo_price = $price_list->kilo_price;
            $minute_price = $price_list->minute_price;
            $start_price = $price_list->start_price;

            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $trip->trip_start_time);
            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now());
            $time_in_minutes = $from->diffInMinutes($to);
            $distance =  floatval($request->distance);

            $total_cost = ($distance * $kilo_price) + ($time_in_minutes * $minute_price) +  $start_price;

            $trip->update([
                'cost' => number_format($total_cost,2),
                'status' => 'finished',
                'trip_end_time' =>  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now()),
                'trip_time' => $time_in_minutes,
                'distance' => $request->distance
            ]);
            //----check Customer Wallet to return Cost to Driver ----
            $cost_required = $this->checkCustomerWallet($trip->client_id,$trip->driver_id, $trip);

            return $this->returnData([
                'المبلغ قبل الخصم من محفظه المستخدم' => number_format($total_cost,2),
                'المبلغ المطلوب' =>  number_format($cost_required,2)
            ], "تم إنهاء الرحله بنجاح");
        } else {
            return $this->returnError("لا يمكنك انهاء هذه الرحله الان !");
        }
    }

    public function checkCustomerWallet($customer_id, $driver_id,$trip)
    {
        $customer_wallet = Wallet::select('wallets.*')->where('customer_id', $customer_id)->first();
        $driver_wallet = DriverWallet::select('driver_wallets.*')->where('driver_id', $driver_id)->first();
        $cost = number_format($trip->cost,2);
        $wallet_balance = $customer_wallet->wallet_balance;
        // if customer wallet greater than 0 
        if ($wallet_balance > 0) {
            //first case wallet have value greater than cost
            if ($wallet_balance >= $cost) {
                //--remove cost value from customer wallet
                $wallet_balance -= $cost;
                $customer_wallet->wallet_balance = $wallet_balance;
                $customer_wallet->save();
                $cost = 0;

                //----create customer wallet History
                WalletHistoryGeneralHelper::addCustomerWalletHistory($cost,"Customer","Minus",$trip->client_id,$customer_wallet->id,$trip->id);
                
                //----add cost value to driver wallet
                $driver_wallet->wallet_balance += $cost;
                $driver_wallet->save();
                //---create driver wallet history
                WalletHistoryGeneralHelper::addDriverWalletHistory( $cost,"Driver","Add",$driver_id, $driver_wallet->id, $trip->id);


            //case 2 when cost value greater than wallet ballance
            } else if ($cost > $wallet_balance) {
                //remove cost value from customer wallet
                $reset = $cost - $wallet_balance;
                
                $customer_wallet->wallet_balance = 0;
                $customer_wallet->save();
                //--add to customer history
                WalletHistoryGeneralHelper::addCustomerWalletHistory($reset,"Customer","Minus",$trip->client_id,$customer_wallet->id,$trip->id);

                //add cost value to driver wallet 
                $driver_wallet->wallet_balance += $wallet_balance;
                $driver_wallet->save();
                //---create driver wallet history
                WalletHistoryGeneralHelper::addDriverWalletHistory( $reset,"Driver","Add",$driver_id, $driver_wallet->id, $trip->id);

                $cost = $reset;

            }
        }

        return $cost;
    }

    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
