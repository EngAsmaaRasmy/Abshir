<?php

namespace App\Http\Controllers\admin;

use App\Helpers\GeideaHistoryHelper;
use App\Helpers\WalletHistoryGeneralHelper;
use App\Http\Controllers\Controller;
use App\Models\AdminWallet;
use App\Models\Customer;
use App\Models\DriverWallet;
use App\Models\GeideaAccount;
use App\Models\GeideaHistory;
use App\Models\Trip;
use App\Models\Wallet;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;

class GeideaPaymentController extends Controller
{
    use ResonseTrait;
    public function getPage($trip_id)
    {
        $trip = Trip::select('id', 'client_id', 'driver_id', 'cost', 'cost_after_discount')->where('id', $trip_id)->first();
        return view('landing_page.payment', compact('trip'));
    }

    public function paidSuccess(Request $request)
    {


        // return $request->all();
        $trip = Trip::where('id', $request->trip_id)->first();
        if ($trip) {

            $admin_wallet = AdminWallet::select('admin_wallets.*')->where('admin_id', 2)->first();
            // return $admin_wallet;

            $driver_wallet = DriverWallet::select('driver_wallets.*')->where('driver_id', $request->driver_id)->first();

            $admin_wallet_balance = $admin_wallet->wallet_balance;
            $admin_wallet_balance -= $request->cost;
            $admin_wallet->wallet_balance = $admin_wallet_balance;
            $admin_wallet->save();


            //----create customer wallet History
            WalletHistoryGeneralHelper::addAdminWalletHistory($request->cost, "APP", "Minus", $trip->client_id, $admin_wallet->id);



            $driver_wallet->wallet_balance += $request->cost;
            $driver_wallet->save();
            //---create driver wallet history
            WalletHistoryGeneralHelper::addDriverWalletHistory($request->cost, "Driver", "Add", $trip->driver_id, $driver_wallet->id, $trip->id);

            //-----Add Geidea History
            $geideaAccount = GeideaAccount::where('id', 1)->first();
            if ($geideaAccount) {

                $geideaAccount->balance += $request->cost;
                $geideaAccount->save();
            } else {
                GeideaAccount::create([
                    'id' => 1,
                    'balance' => $request->cost
                ]);
            }
            GeideaHistoryHelper::addGeideaHistoryApp(1, $trip->id, $request->cost, 'Add', 'APP', $trip->client_id);
        } else {
            return false;
        }


        return $request->trip;
    }
    public function response(Request $request)
    {
        if ($request->response == "success") {
            return $this->returnSuccess("تم الدفع بنجاح");
        } elseif ($request->response == "error") {
            return $this->returnError("يوجد  خطأ ما الرجاء التجربه مره اخرى");
        } elseif ($request->response == "cancel") {
            return $this->returnError("تم الغاء العملية..");
        }
    }

    public function getSuccessPage()
    {
        return view('landing_page.payment_success');
    }
    public function getFailedPage()
    {
        return view('landing_page.payment_failed');
    }

    public function getGeideaDashboard()
    {
        $geideaHistories = GeideaHistory::where('geidea_account_id', 1)->orderBy('created_at', 'DESC')->paginate(PAGINATION);
        $geideaAccountBalance = GeideaAccount::select('balance')->where('id', 1)->first();
        return view('landing_page.GeideaHistory', compact('geideaHistories', 'geideaAccountBalance'));
    }
    public function GeideaBalanceWithdrawal(Request $request)
    {
        $geideaAccount = GeideaAccount::where('id', 1)->first();
        if ($geideaAccount) {

            $geideaAccount->balance -= $request->balance;
            $geideaAccount->save();
        } else {
            GeideaAccount::create([
                'id' => 1,
                'balance' => 0
            ]);
        }
        GeideaHistoryHelper::addGeideaHistoryApp(1, null, $request->balance, 'Minus', 'Admin', null);
        return redirect()->route("geidea.history")->with(["success" => "تم سحب المبلغ من المحفظة بنجاح"]);
    }

    public function getChargedPage($customer_id, $amount)
    {
        $customer = Customer::where('id', $customer_id)->first();
        return view('landing_page.customer_charged_page', compact('customer', 'amount'));
    }
    public function chargedSuccess(Request $request)
    {
        $customer = Customer::where('id', $request->customer_id)->first();
        if ($customer) {
            
            $customer_wallet = Wallet::where('customer_id', $customer->id)->first();
            $admin_wallet = AdminWallet::where('admin_id', 2)->first();

            $customer_wallet->wallet_balance += $request->amount;
            $customer_wallet->save();
            WalletHistoryGeneralHelper::addCustomerWalletHistory($request->amount, 'Customer', 'Add', $customer->id, $customer_wallet->id, null);


            $admin_wallet_balance = $admin_wallet->wallet_balance;
            $admin_wallet_balance -= $request->amount;
            $admin_wallet->wallet_balance = $admin_wallet_balance;
            $admin_wallet->save();



            WalletHistoryGeneralHelper::addAdminWalletHistory($request->amount, "APP", "Minus", $customer->id, $admin_wallet->id);

            //-----Add Geidea History
            $geideaAccount = GeideaAccount::where('id', 1)->first();
            if ($geideaAccount) {

                $geideaAccount->balance += $request->amount;
                $geideaAccount->save();
            } else {
                GeideaAccount::create([
                    'id' => 1,
                    'balance' => $request->cost
                ]);
            }
            GeideaHistoryHelper::addGeideaHistoryApp(1, null, $request->amount, 'Add', 'APP', $customer->id);
        } else {
            return false;
        }


        return $customer->id;
    }
}
