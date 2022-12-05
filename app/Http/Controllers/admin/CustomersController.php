<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Wallet;
use App\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\WalletHistoryGeneralHelper;
use App\Models\AdminWallet;

class CustomersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:عرض العملاء|عرض محفظة العميل|تعديل محفظة العميل|تفعيل العميل', ['only' => ['index', 'show']]);
        $this->middleware('permission:عرض محفظة العميل', ['only' => ['getCustomerWallet', 'save']]);
        $this->middleware('permission:تعديل محفظة العميل', ['only' => ['updateCustomerWallet']]);
        $this->middleware('permission:تفعيل العميل', ['only' => ['toggleActive']]);
    }

    public function index()
    {
        try {
            $customers = Customer::select('customers.*', 'wallets.wallet_balance')
                ->leftjoin('wallets', 'wallets.customer_id', 'customers.id')
                ->paginate(100);
            return view("admin.customers.display", compact('customers'));
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }
    }


    public function toggleActive($id)
    {
        try {
            $customer = Customer::query()->findOrFail($id);
            if ($customer->active == 1) {
                $customer->active = 0;
            } else {
                $customer->active = 1;
            }

            $customer->save();
            return redirect()->back()->with(['success' => "تم التعديل بنجاح"]);
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    public function getCustomerWallet($customer_id)
    {
        $wallet = Wallet::select('id', 'wallet_balance', 'customer_id')->where('customer_id', $customer_id)->first();
        if (!$wallet) {
            $wallet = new Wallet();
            $wallet->wallet_balance = '0';
            $wallet->customer_id = $customer_id;
            $wallet->save();
        }
        $wallet_history = WalletHistory::select('wallet_histories.*', 'admins.name as adminName', 'customers.name as customerName')
            ->leftjoin('admins', 'admins.id', 'wallet_histories.added_by')
            ->leftjoin('customers', 'customers.id', 'wallet_histories.added_by')
            ->where('wallet_id', $wallet->id)
            ->paginate(100);

        return view('admin.customers.customer_wallet', compact('wallet', 'wallet_history'));
    }
    public function updateCustomerWallet(Request $request)
    {
        $wallet = Wallet::where('id', $request->wallet_id)->first();
        if ($request->type == "Add") {
            $wallet_balance = $request->wallet_balance + $request->value;
            $wallet->wallet_balance = $wallet_balance;
            $wallet->save();
            WalletHistoryGeneralHelper::addCustomerWalletHistory($request->value, "Admin", "Add", Auth::id(), $request->wallet_id,null);
            //remove value from admin wallet 
            $admin_wallet = AdminWallet::where('admin_id', 2)->first();
            $admin_wallet->wallet_balance -= $request->value;
            $admin_wallet->save();
            WalletHistoryGeneralHelper::addAdminWalletHistory($request->value, "Admin", "Minus", Auth::id(), $admin_wallet->id,null);
        } else if ($request->type == "Minus") {
            $wallet_balance = $request->wallet_balance - $request->value;
            $wallet->wallet_balance = $wallet_balance;
            $wallet->save();
            WalletHistoryGeneralHelper::addCustomerWalletHistory($request->value, "Admin", "Minus", Auth::id(), $request->wallet_id,null);

            //add value from admin wallet 
            $admin_wallet = AdminWallet::where('admin_id', 2)->first();
            $admin_wallet->wallet_balance += $request->value;
            $admin_wallet->save();
            WalletHistoryGeneralHelper::addAdminWalletHistory($request->value, "Admin", "Add", Auth::id(), $admin_wallet->id);
        }

        return redirect()->route('customers.index');
    }
}
