<?php

namespace App\Http\Controllers\admin;

use App\Exports\DriverDayExport;
use App\Exports\DriversExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CategoryRequest;
use App\Http\Requests\admin\DriverRequest;
use App\Models\admin\CategoryModel;
use App\Models\admin\DriverModel;
use App\Models\Document;
use App\Models\Identity;
use App\Models\Vehicle;
use App\Models\DriverAddress;
use App\Models\DriverWallet;
use App\Models\DriverWalletHistory;
use App\Models\License;
use App\Models\Trip;
use App\traits\ImageTrait;
use App\traits\FCMTrait;
use App\traits\ResonseTrait;
use App\Helpers\WalletHistoryGeneralHelper;
use App\Models\AdminWallet;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use SebastianBergmann\CodeCoverage\Driver\Driver;

class DriverController extends Controller
{
    use ImageTrait;
    use FCMTrait;
    use ResonseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:عرض السائقين تحت الإنشاء', ['only' => ['getUnderConstruction', 'UnderConstruction']]);
        $this->middleware('permission:عرض السائقين بإنتظار الموافقة عليهم', ['only' => ['pending']]);
        $this->middleware('permission:عرض السائقين تم تفعيل حسابهم', ['only' => ['approval']]);
        $this->middleware('permission:عرض السائقين المحظورين', ['only' => ['blocked', 'getBlocked']]);
        $this->middleware('permission:تعديل سائق', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف سائق', ['only' => ['delete']]);
        $this->middleware('permission:عرض سائق', ['only' => ['show_driver']]);
        $this->middleware('permission:عرض كشف حساب السائق', ['only' => ['driverAccount']]);
    }

    public function export() 
    {
        try {
            return Excel::download(new DriversExport, 'drivers.xlsx');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
        }
        return redirect()->back();
    }

    public function dayExport() 
    {
        try {
            return Excel::download(new DriverDayExport, 'drivers_for_day.xlsx');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
        }
        return redirect()->back();
    }

    public function getUnderConstruction()
    {
        return view("admin.drivers.underConstruction");
    }
    public function UnderConstruction($status)
    {
        $drivers = DriverModel::where('status', $status)->paginate(PAGINATION);
        return $this->returnData($drivers, "");
    }
    public function pending()
    {
        $drivers = DriverModel::where('status', '4')->paginate(PAGINATION);
        return view("admin.drivers.pending", compact("drivers"));
    }
    public function approval()
    {
        $drivers = DriverModel::where('status', '5')->paginate(PAGINATION);
        return view("admin.drivers.approval", compact("drivers"));
    }
    public function getBlocked()
    {
        return view("admin.drivers.blocked");
    }
    public function blocked($status)
    {
        $drivers = DriverModel::where('status', $status)->paginate(PAGINATION);
        return $this->returnData($drivers, "");
    }


    public function show_driver($id)
    {
        $driver = DriverModel::find($id);
        $vehicle_info = Vehicle::where('driver_id', $id)->first();
        $document = Document::where('driver_id', $id)->first();
        $license_info = License::where('driver_id', $id)->first();
        $identity_info = Identity::where('driver_id', $id)->first();
        $address_info = DriverAddress::where('driver_id', $id)->first();
        $trips_info = Trip::where('driver_id', $id)->get();
        $balance = Trip::where('driver_id', $id)->sum('cost');

        return view("admin.drivers.display", compact('balance', "trips_info", "driver", "vehicle_info", "license_info", "identity_info", "address_info", "document"));
    }

    public function editComment($id)
    {
        $driver = DriverModel::find($id);
        return view("admin.drivers.addComment", compact("driver"));
    }

    public function updateComment(Request $request ,$id)
    {
        $driver = DriverModel::find($id);
        if($driver) {
            $driver->comment = $request->comment;
            $driver->save();
            return redirect()->back()->with(["success" => "تم   إضافة تعليق بنجاح"]);
        } else {
            return redirect()->back()->with(["error" => "غير موجود"]);
        }
    }

    public function driverAccount($id)
    {
        $wallet = DriverWallet::select('id', 'wallet_balance', 'driver_id')->where('driver_id', $id)->first();
        $wallet_history = DriverWalletHistory::select('driver_wallet_histories.*', 'admins.name as adminName', 'drivers.fullname as driverName')
            ->leftjoin('admins', 'admins.id', 'driver_wallet_histories.added_by')
            ->leftjoin('drivers', 'drivers.id', 'driver_wallet_histories.added_by')
            ->where('wallet_id', $wallet->id)
            ->paginate(100);
        return view("admin.drivers.account", compact('wallet', "wallet_history"));
    }
    public function getDriverWallet($driverId)
    {
        $wallet = DriverWallet::select('id', 'wallet_balance', 'driver_id')->where('driver_id', $driverId)->first();
        if (!$wallet) {
            $wallet = new DriverWallet();
            $wallet->wallet_balance = '0';
            $wallet->driver_id = $driverId;
            $wallet->save();
        }
        $wallet_history = DriverWalletHistory::select('driver_wallet_histories.*', 'admins.name as adminName', 'drivers.fullname as driverName')
            ->leftjoin('admins', 'admins.id', 'driver_wallet_histories.added_by')
            ->leftjoin('drivers', 'drivers.id', 'driver_wallet_histories.added_by')
            ->where('wallet_id', $wallet->id)
            ->paginate(100);

        return view('admin.drivers.driver_wallet', compact('wallet', 'wallet_history'));
    }
    public function updateDriverWallet(Request $request)
    {
        $wallet = DriverWallet::where('id', $request->wallet_id)->first();
        if ($request->type == "Add") {
            $wallet_balance = $request->wallet_balance + $request->value;
            $wallet->wallet_balance = $wallet_balance;
            $wallet->save();
            WalletHistoryGeneralHelper::addDriverWalletHistory($request->value, "Admin", "Add", Auth::id(), $request->wallet_id);

            //remove value from admin wallet 
            $admin_wallet = AdminWallet::where('admin_id', 2)->first();
            $admin_wallet->wallet_balance -= $request->value;
            $admin_wallet->save();
            WalletHistoryGeneralHelper::addAdminWalletHistory($request->value, "Admin", "Minus", Auth::id(), $admin_wallet->id);
        } else if ($request->type == "Minus") {
            $wallet_balance = $request->wallet_balance - $request->value;
            $wallet->wallet_balance = $wallet_balance;
            $wallet->save();
            WalletHistoryGeneralHelper::addDriverWalletHistory($request->value, "Admin", "Minus", Auth::id(), $request->wallet_id);

            //add value from admin wallet 
            $admin_wallet = AdminWallet::where('admin_id', 2)->first();
            $admin_wallet->wallet_balance += $request->value;
            $admin_wallet->save();
            WalletHistoryGeneralHelper::addAdminWalletHistory($request->value, "Admin", "Add", Auth::id(), $admin_wallet->id);
        }

        return redirect()->back();
    }


    public function delete($id)
    {
        try {
            $driver = DriverModel::find($id);
            if (!$driver) {
                return redirect()->route("driver.show")->with(["error" => "غير موجود"]);
            } else {
                $driver->delete();
                return redirect()->route("driver.show")->with(["success" => "تم حذف السائق بنجاح"]);
            }
        } catch (\Throwable $e) {
            return redirect()->route("driver.show")->with(["error" => "حدث خطأ ما برجاء المحاوله مرة اخرى"]);
        }
    }

    public function edit($id)
    {
        $driver = DriverModel::find($id);
        if (!$driver) {
            return redirect()->route("driver.show")->with(["error" => "غير موجود"]);
        } else {

            return view("admin.drivers.edit", compact("driver"));
        }
    }

    public function update(Request $request, $id)
    {


        try {

            $driver = DriverModel::find($id);
            if (!$driver) {
                return redirect()->route("driver.show")->with(["error" => "غير موجود"]);
            } else {
                $valid = $this->validateRequest($request, $driver->id, $driver->phone != $request->phone, $driver->username != $request->username);
                if ($valid->fails()) {
                    return redirect()->route("driver.edit", $id)->withErrors($valid->errors());
                } else {
                    $driver->fullname = $request->fullname;
                    $driver->username = $request->username;
                    $driver->phone = $request->phone;
                    if ($request->password) {
                        $driver->password = Hash::make($request->password);
                    }
                    $driver->address = $request->address;
                    $driver->active = $request->active;
                    $driver->save();
                    return redirect()->route("driver.show")->with(["success" => "تم تعديل بيانات السائق بنجاح"]);
                }
            }
        } catch (\Throwable $e) {
            return redirect()->route("driver.show")->with(["error" => "حدث خطأ ما برجاء المحاوله مرة اخرى"]);
        }
    }

    public function typeofUse(Request $request, $id)
    {
        // dd($request->all());
        try {
            $driver = DriverModel::find($id);
            if (!$driver) {
                return redirect()->route("driver.show")->with(["error" => "غير موجود"]);
            } else {
                if ($request->has('is_delivery')) {
                    $driver->is_delivery = $request->is_delivery;
                }else{
                    $driver->is_delivery = 0;

                }
                if ($request->has('is_ride')) {
                    $driver->is_ride = $request->is_ride;
                }else{
                    $driver->is_ride = 0;
                    
                }
                $driver->save();
                return redirect()->back()->with(["success" => "تم تعديل بيانات السائق بنجاح"]);
            }
        } catch (\Throwable $e) {
            return redirect()->route("driver.show")->with(["error" => "حدث خطأ ما برجاء المحاوله مرة اخرى"]);
        }
    }

    public function toggleActive($id)
    {
        try {
            $driver = DriverModel::query()->findOrFail($id);
            if ($driver->active == 0) {
                $driver->active = 1;
                if ($driver->status == '4' || $driver->status == '7') {
                    $driver->status = '5'; //APPROVED
                    $driver->save();
                    $fcm = $this->sendToUser($driver->fcm_token, "تم تفعيل الحساب بنجاح", 'تم تفعيل حسابك بنجاح');
                    if ($fcm->status() == 200) {
                        return redirect()->back()->with(['success' => "تم  قبول السائق بنجاح"]);
                    }
                }
            } else {
                $driver->active = 0;
                if ($driver->status == '5') {
                    $driver->status = '7'; //BLOCK
                    $driver->save();
                    $fcm = $this->sendToUser($driver->fcm_token, "تم إلغاء تفعيل الحساب ", 'تم  إلغاء تفعيل حسابك ');
                    if ($fcm->status() == 200) {
                        return redirect()->back()->with(['success' => "تم  حظر السائق "]);
                    }
                }
            }
            return redirect()->back();
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function validateRequest(Request $request, $id, $phoneChanged, $usernameChanged)
    {


        $phoneRule = $phoneChanged == true ? "required|unique:drivers,phone|max:11|min:11" : "required";
        $usernameRule = $usernameChanged == true ? "required|unique:drivers,username" : "required";

        return  $valid = validator()->make(
            $request->all(),
            [
                "username" => $usernameRule,
                "fullname" => "required",

                "phone" => $phoneRule,
                "address" => "required",
                "active" => "required"

            ],
            [

                "required" => "هذا الحقل مطلوب",
                "unique" => "هذه البيانات مسجله بالفعل"
            ]
        );
    }
}
