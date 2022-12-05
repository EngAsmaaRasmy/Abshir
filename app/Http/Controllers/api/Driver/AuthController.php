<?php

namespace App\Http\Controllers\api\Driver;

use App\Governorate;
use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Driver\RegisterDriverRequest;
use App\Http\Requests\Driver\StoreCarDetailsRequest;
use App\Http\Requests\Driver\StoreDocumentsRequest;
use App\Http\Requests\Driver\StorePersonalDetailsDriverRequest;
use App\Http\Requests\Emergency\MakeEmergencyRequest;
use App\Http\Resources\Driver\PersonalDetailsDriverResource;
use App\Http\Resources\Driver\RegisterDriverResource;
use App\Http\Resources\UserResource;
use App\Models\admin\DriverModel;
use App\Models\Customer;
use App\Models\City;
use App\Models\Document;
use App\Models\License;
use App\Models\DriverAddress;
use App\Models\DriverReview;
use App\Models\DriverWallet;
use App\Models\Emergency;
use App\Models\Identity;
use App\Models\Vehicle;
use App\Models\Transportation;
use App\Models\Trip;
use App\Models\VehiclesMarker;
use App\Models\VehiclesModel;
use App\traits\ImageTrait;
use App\traits\ResonseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    use ResonseTrait;
    use ImageTrait;
    public  function login(Request $request)
    {
        try {
            $valid = $this->validateLoginRequest($request);
            if ($valid->fails()) {
                return  $this->returnError($valid->errors()->first());
            } else {

                $driver = DriverModel::where('phone', $request->phone)->first();
                if (!$driver || !Hash::check($request->password, $driver->password)) {
                    return  $this->returnError("الرقم او كلمة السر مش صح");
                } else {
                    $token = Str::random(60);
                    $driver->update([
                        "api_token" => $token,
                        "fcm_token" => $request->fcm_token
                    ]);
                    $driver = DriverModel::select('drivers.id', 'drivers.fcm_token', 'drivers.password','drivers.api_token as token', 'identities.expiry_date as driver_license_expiry_date', 'identities.gender', 'vehicles.vehicle_year', 'vehicles.type', 'licenses.expiry_date as vehicle_license_expiry_date')
                        ->leftjoin('identities', 'identities.driver_id', 'drivers.id')
                        ->leftjoin('vehicles', 'vehicles.driver_id', 'drivers.id')
                        ->leftjoin('licenses', 'licenses.driver_id', 'drivers.id')
                        ->where('drivers.id',  $driver->id)
                        ->first();
                    

                    return $this->returnData($driver, "تم الدخول بنجاح");
                }
            }
        } catch (\Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }
    public  function register(RegisterDriverRequest $request)
    {
        try {

            $captain = DriverModel::create([
                'fullname' => $request->fullname,
                "phone" => $request->phone,
                "api_token" => Str::random(60),
                "fcm_token" => $request->fcm_token,
                "active" => 0,
                'status' => '1',
                "password" => Hash::make($request->input("password")),

            ]);

            //-----Create default Wallet for Driver
            DriverWallet::create([
                'driver_id' => $captain->id,
                'wallet_balance' => 0
            ]);
            return $this->returnData(new RegisterDriverResource($captain), "تم التسجيل بنجاح");
        } catch (\Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }
    public function storePersonalDetails(StorePersonalDetailsDriverRequest $request)
    {

        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            if ($driver->status == '1') {

                //save data in driver table
                $driver->date_of_birth = $request->date_of_birth;
                $driver->license_number = $request->license_number;
                $driver->status = '2';

                if ($request->hasFile('image')) {

                    $url = $this->saveImage($request->file('image'), "drivers", $driver->id . rand(1, 100) . rand(100, 1000));
                    $driver->image = $url;
                    // $file = $request->file("image");
                    // $filename = Str::random(6) . '_' . time() . '_' . $file->getClientOriginalName();
                    // $uploads_folder =  getcwd() . '/images/drivers';
                    // if (!file_exists($uploads_folder)) {
                    //     mkdir($uploads_folder, 0777, true);
                    // }
                    // $file->move($uploads_folder, $filename);
                    // dd("Aasaaaaaa");
                }

                if ($request->hasFile('driving_license')) {
                    $url = $this->saveImage($request->file('driving_license'), "drivers", $driver->id . rand(1, 100) . rand(100, 1000));
                    $driver->driving_license = $url;
                    // $file = $request->file("driving_license");
                    // $filename = Str::random(6) . '_' . time() . '_' . $file->getClientOriginalName();
                    // $uploads_folder =  getcwd() . '/images/drivers';
                    // if (!file_exists($uploads_folder)) {
                    //     mkdir($uploads_folder, 0777, true);
                    // }
                    // $file->move($uploads_folder, $filename);

                }
                if ($request->hasFile('driving_license_back')) {
                    $url = $this->saveImage($request->file('driving_license_back'), "drivers", $driver->id . rand(1, 100) . rand(100, 1000));
                    $driver->driving_license_back = $url;
                }

                $driver->save();
                // save data in identity table
                $identity = new Identity();
                $identity->driver_id        = $driver->id;
                $identity->identity_number  = $request->identity_number;
                $identity->expiry_date      = $request->expiry_date;
                $identity->gender           = $request->gender;

                if ($request->hasFile('identity_image')) {
                    $url = $this->saveImage($request->file('identity_image'), "vehicles", $driver->id . rand(1, 100) . rand(100, 1000));
                    $identity->identity_image = $url;

                    // $file = $request->file("identity_image");
                    // $filename = Str::random(6) . '_' . time() . '_' . $file->getClientOriginalName();
                    // $uploads_folder =  getcwd() . '/images/vehicles';
                    // if (!file_exists($uploads_folder)) {
                    //     mkdir($uploads_folder, 0777, true);
                    // }
                    // $file->move($uploads_folder, $filename);
                }
                if ($request->hasFile('identity_image_back')) {
                    $url = $this->saveImage($request->file('identity_image_back'), "vehicles", $driver->id . rand(1, 100) . rand(100, 1000));
                    $identity->identity_image_back = $url;
                }

                $identity->save();
                return $this->returnSuccess('تم حفظ البيانات الشخصية');
            } else {
                return $this->returnError('تم تسجيل البيانات مسبقا');
            }
        } else {
            return $this->returnError('unauthorized');
        }
    }

    public function storeCarDetails(StoreCarDetailsRequest $request)
    {
        if ($driver = GeneralHelper::currentDriver($request->header('Authorization'))) {
            if ($driver->status == '2') {

                $licence = new License;
                $licence->driver_id       = $driver->id;
                $licence->license_number  = $request->license_number;
                $licence->expiry_date     = $request->expiry_date;
                $licence->save();

                $vehicle = new Vehicle;
                $vehicle->driver_id       = $driver->id;
                $vehicle->marker_id       = $request->car_marker;
                $vehicle->governorate_id       = $request->governorate_id;
                $vehicle->model_id        = $request->car_model;
                $vehicle->plate_number    = $request->plate_number;
                $vehicle->vehicle_color   = $request->vehicle_color;
                $vehicle->vehicle_year    = $request->vehicle_year;
                $vehicle->type            = $request->type;

                if ($request->hasFile('vehicle_license_image')) {
                    $url = $this->saveImage($request->file('vehicle_license_image'), "vehicles", $driver->id . rand(1, 100) . rand(100, 1000));
                    $vehicle->vehicle_license_image = $url;

                    // $file = $request->file("vehicle_license_image");
                    // $filename = Str::random(6) . '_' . time() . '_' . $file->getClientOriginalName();
                    // $uploads_folder =  getcwd() . '/images/vehicles';
                    // if (!file_exists($uploads_folder)) {
                    //     mkdir($uploads_folder, 0777, true);
                    // }
                    // $file->move($uploads_folder, $filename);

                }
                if ($request->hasFile('vehicle_license_image_back')) {
                    $url = $this->saveImage($request->file('vehicle_license_image_back'), "vehicles", $driver->id . rand(1, 100) . rand(100, 1000));
                    $vehicle->vehicle_license_image_back = $url;
                }

                $vehicle->save();

                $driver->status = '3';
                $driver->save();

                return $this->returnSuccess("تم تعديل البيانات بنجاح");
            } else {
                if ($driver->status == '3') {
                    return $this->returnError("تم تسجيل بيانات السياره مسبقا");
                }
                return $this->returnError("برجاء تسجيل المعلومات الشخصيه اولا!");
            }
        } else {
            return $this->returnError('unauthorized');
        }
    }

    public function storeDocuments(StoreDocumentsRequest $request)
    {
        // dd($request->all());
        if ($driver = GeneralHelper::currentDriver($request->header('Authorization'))) {
            if ($driver->status == '3') {

                $document = new Document();
                $document->driver_id = $driver->id;
                if ($request->hasFile('criminal_chip_image')) {
                    $url = $this->saveImage($request->file('criminal_chip_image'), "documents", $driver->id . rand(1, 100) . rand(100, 1000));
                    $document->criminal_chip_image = $url;
                    // $file = $request->file("criminal_chip_image");
                    // $filename = Str::random(6) . '_' . time() . '_' . $file->getClientOriginalName();
                    // $uploads_folder =  getcwd() . '/images/documents';
                    // if (!file_exists($uploads_folder)) {
                    //     mkdir($uploads_folder, 0777, true);
                    // }
                    // $file->move($uploads_folder, $filename);
                }
                if ($request->hasFile('examination_report')) {

                    $url = $this->saveImage($request->file('examination_report'), "documents", $driver->id . rand(1, 100) . rand(100, 1000));
                    $document->examination_report = $url;
                    // $file = $request->file("examination_report");
                    // $filename = Str::random(6) . '_' . time() . '_' . $file->getClientOriginalName();
                    // $uploads_folder =  getcwd() . '/images/documents';
                    // if (!file_exists($uploads_folder)) {
                    //     mkdir($uploads_folder, 0777, true);
                    // }
                    // $file->move($uploads_folder, $filename);
                }
                if ($request->hasFile('contract_image')) {
                    $url = $this->saveImage($request->file('contract_image'), "documents", $driver->id . rand(1, 100) . rand(100, 1000));
                    $document->contract_image = $url;
                    // $file = $request->file("contract_image");
                    // $filename = Str::random(6) . '_' . time() . '_' . $file->getClientOriginalName();
                    // $uploads_folder =  getcwd() . '/images/documents';
                    // if (!file_exists($uploads_folder)) {
                    //     mkdir($uploads_folder, 0777, true);
                    // }
                    // $file->move($uploads_folder, $filename);
                }
                if ($document->save()) {
                    $driver->status = '4';
                    $driver->save();
                    return $this->returnSuccess('تم التعديل بنجاح');
                }
            } else {
                if ($driver->status == '4') {
                    return $this->returnError('تم حفظ المستندات مسبقا!');
                }
                return $this->returnError('برجاء تسجيل معلومات السياره اولا!');
            }
        } else {

            return $this->returnError('unauthorized');
        }
    }
    public function getCarMarkers(Request $request)
    {
        $markers = VehiclesMarker::select('id', 'marker')->get();
        return $this->returnData($markers, 'تم الحصول على ال markers');
    }
    public function getCarModels(Request $request)
    {
        $models = VehiclesModel::select('vehicles_models.id', 'vehicles_models.model', 'vehicles_markers.marker')
            ->leftjoin('vehicles_markers', 'vehicles_markers.id', 'vehicles_models.marker_id')
            ->where('vehicles_models.marker_id', $request->marker_id)->get();

        return $this->returnData($models, 'تم الحصول على ال models');
    }

    public function getGovernorates(Request $request)
    {
        $governorates = Governorate::select('id', 'name')->get();

        return $this->returnData($governorates, 'تم الحصول على المحافظات ');
    }

    public function checkAuthenticationStatus(Request $request)
    {
        if ($driver = GeneralHelper::currentDriver($request->header('Authorization'))) {
            return $this->returnData(['status' => $driver->status], '');
        } else {
            return $this->returnError('unauthorized');
        }
    }
    public function getDriverId(Request $request)
    {
        if ($driver = GeneralHelper::currentDriver($request->header('Authorization'))) {
            return $this->returnData(['id' => $driver->id], '');
        } else {
            return $this->returnError('unauthorized');
        }
    }
    public  function cities()
    {
        return $this->returnData(City::select(['id', 'name'])->get(), "");
    }

    public  function transportations()
    {
        return $this->returnData(Transportation::select(['id', 'name'])->get(), "");
    }


    public function checkToken(Request $request)
    {
        try {
            $driver = DriverModel::where("id", $request->user_id)->where("active", 1)->get()->first();
            return $this->returnData($driver, "");
        } catch (\Throwable $e) {
            return $this->returnException();
        }
    }
    public function refreshToken(Request $request)
    {
        try {
            $driver = GeneralHelper::currentDriver($request->header('Authorization'));
            $driver->update([
                "fcm_token" => $request->fcm_token
            ]);

            return $this->returnSuccess("تم تحديث التوكين بنجاح");
        } catch (\Throwable $e) {
            return $this->returnException();
        }
    }


    protected  function validateLoginRequest(Request $request)
    {
        return validator()->make($request->all(), [
            "phone" => "required",
            "password" => "required"
        ], [

            "required" => "بعض المعلومات المطلوبة غير مكتملة"
        ]);
    }

    protected  function validateRegisterRequest(Request $request)
    {
        return validator()->make($request->all(), [
            "fullname" => "required|min:6",
            "phone" => "required|min:6|unique:drivers",
            "email" => "required|email|unique:drivers",
            "password" => "required|confirmed|min:6"
        ]);
    }

    protected  function validateUpdateRequest(Request $request)
    {
        $token = $request->header('Authorization');
        if (Str::startsWith($token, "Bearer")) {
            $token = Str::substr($token, 7);
        }
        $driver = DriverModel::where("api_token", $token)->get()->first();

        return validator()->make($request->all(), [
            "fullname" => "|min:6",
            "phone" => "|min:6|unique:drivers,phone," . $driver->id,
            'email' => '|email|unique:drivers,email,' . $driver->id,
            'city_id' => '|exists:cities,id',
            'transportation_id' => '|exists:transportations,id',

        ]);
    }
    public function GetProfile(Request $request)
    {
        $token = $request->header('Authorization');

        if (Str::startsWith($token, "Bearer")) {
            $token = Str::substr($token, 7);
        }

        $driver = DriverModel::select('drivers.*', 'driver_wallets.wallet_balance')
            ->leftjoin('driver_wallets', 'driver_wallets.driver_id', 'drivers.id')
            ->where("api_token", $token)->first();

        return $this->returnData(new UserResource($driver), "");
    }

    public function profile(Request $request)
    {
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            $driver = DriverModel::select(
                'drivers.id',
                'drivers.fullname',
                'drivers.phone',
                'drivers.image',
                'drivers.is_delivery',
                'drivers.is_ride',
                'driver_wallets.wallet_balance',
                'vehicles.vehicle_type'
            )
                ->leftjoin('driver_wallets', 'driver_wallets.driver_id', 'drivers.id')
                ->leftjoin('vehicles', 'vehicles.driver_id', 'drivers.id')
                ->leftjoin('driver_reviews', 'driver_reviews.driver_id', 'drivers.id')
                ->where('drivers.id', $driver->id)->first();

            $rate = DriverReview::where('driver_id', $driver->id)->sum('rate');
            if ($rate) {
                $rate = $rate / DriverReview::where('driver_id', $driver->id)->count();
            }
            $trip = Trip::where('driver_id', $driver->id)->where('status', 'ended')->count();
            $driver->finished_trips = $trip;
            $driver->rate = number_format((float)$rate, 2);

            return $this->returnData($driver, "Fetch Driver Data successfully");
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function incomings(Request $request)
    {
        $authDriver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($authDriver) {
            $costs = [];

            $driver = DriverModel::select('drivers.id', DB::raw('(SUM(trips.cost)) AS totalIncomings'))
                ->leftjoin('trips', 'trips.driver_id', 'drivers.id')
                ->where('drivers.id', $authDriver->id);

            $total_trips = Trip::where('driver_id', $authDriver->id)
                ->where('status', 'ended');

            $total_cashes = Trip::where('driver_id', $authDriver->id)
                ->where('status', 'ended')
                ->where('type_of_payment', 1);

            if ($request->duration == 1) {
                $driver->whereDate("trips.created_at", Carbon::today());
                $total_trips->whereDate("created_at", Carbon::today());
                $total_cashes->whereDate("created_at", Carbon::today());

                $chart = Trip::select(DB::raw('sum(cost) as `cost`'), DB::raw("DATE_FORMAT(created_at, '%h') date"), DB::raw('Day(created_at) day, Hour(created_at) hour'))
                    ->whereDate("created_at", Carbon::today())
                    ->where('driver_id', $authDriver->id)
                    ->where('status', 'ended')
                    ->groupby('hour')
                    ->get();

                foreach ($chart as $hour) {
                    $costs[] = [$hour->cost];
                    if ($hour->date == $hour->hour) {
                        $hour->date = $hour->date . " " . "am";
                    } else {
                        $hour->date = $hour->date . " " .  "pm";
                    }
                }
            } else if ($request->duration == 2) {
                $driver->whereBetween('trips.created_at', [Carbon::now()->subDays(7), Carbon::now()]);
                $total_trips->whereBetween('trips.created_at', [Carbon::now()->subDays(7), Carbon::now()]);
                $total_cashes->whereBetween('trips.created_at', [Carbon::now()->subDays(7), Carbon::now()]);

                $chart = Trip::select(DB::raw('FORMAT(sum(cost), 2) as `cost`'), DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y') date"), DB::raw('YEAR(created_at) year, MONTH(created_at) month, Day(created_at) day'))
                    ->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()])
                    ->where('driver_id', $authDriver->id)
                    ->where('status', 'ended')
                    ->groupby('day')
                    ->get();

                foreach ($chart as $max) {
                    $costs[] = [$max->cost];
                }
            } else {
                $driver->whereBetween('trips.created_at', [Carbon::now()->subMonth(6), Carbon::now()]);
                $total_trips->whereBetween('created_at', [Carbon::now()->subMonth(6), Carbon::now()]);
                $total_cashes->whereBetween('created_at', [Carbon::now()->subMonth(6), Carbon::now()]);

                $chart = Trip::select(DB::raw('sum(cost) as `cost`'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') date"), DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                    ->whereBetween('created_at', [Carbon::now()->subMonth(6), Carbon::now()])
                    ->where('driver_id', $authDriver->id)
                    ->where('status', 'ended')
                    ->groupby('year', 'month')
                    ->get();

                foreach ($chart as $max) {
                    $costs[] = [$max->cost];
                }
            }
            $driver = $driver->first();
            $balance = DriverWallet::select('wallet_balance')
                ->where('driver_id', $driver->id)
                ->first();

            if ($balance) {
                if ($balance->wallet_balance > 0) {
                    $driver->driver_to_company = 0.00;
                    $driver->company_to_driver = abs($balance->wallet_balance);
                } else {
                    $driver->driver_to_company = abs($balance->wallet_balance);
                    $driver->company_to_driver = 0.00;
                }
            }
            $driver->totalOrders = $total_trips->count();
            $driver->totalCashes = number_format((float)$total_cashes->sum('cost'), 2);
            $driver->totalIncomings = number_format((float)$driver->totalIncomings, 2);
            if ($costs) {
                $maxCost = max($costs);
                $driver->maxCost = $maxCost[0];
            }
            $driver->chart_data = $chart;

            return $this->returnData($driver, "Fetch Driver Incomings Data successfully");
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    // public function vehicle_data(Request $request)
    // {
    //     $token = $request->header('Authorization');

    //     if (Str::startsWith($token, "Bearer")) {
    //         $token = Str::substr($token, 7);
    //     }

    //     $driver = DriverModel::where("api_token", $token)->first();

    //     if ($vehicle = Vehicle::where('driver_id', $driver->id)->first()) {

    //         if ($request->vehicle_name) {
    //             $vehicle->vehicle_name = $request->vehicle_name;
    //         }
    //         if ($request->vehicle_type) {
    //             $vehicle->vehicle_type = $request->vehicle_type;
    //         }
    //         if ($request->vehicle_model) {
    //             $vehicle->vehicle_model = $request->vehicle_model;
    //         }
    //         if ($request->vehicle_year) {
    //             $vehicle->vehicle_year = $request->vehicle_year;
    //         }
    //         if ($request->plate_number) {
    //             $vehicle->plate_number = $request->plate_number;
    //         }
    //         if ($request->motion_vector) {
    //             $vehicle->motion_vector = $request->motion_vector;
    //         }
    //         if ($request->horse_power) {
    //             $vehicle->horse_power = $request->horse_power;
    //         }
    //         if ($request->vehicle_color) {
    //             $vehicle->vehicle_color = $request->vehicle_color;
    //         }
    //         if ($request->kilometer_count) {
    //             $vehicle->kilometer_count = $request->kilometer_count;
    //         }

    //         if ($request->file('vehicle_image')) {
    //             $url = $this->saveImage($request->file('vehicle_image'), "vehicles", rand(1000, 2555) . rand(1, 100) . rand(100, 1000));
    //             $vehicle->vehicle_image = $url;
    //         }

    //         if ($request->file('vehicle_license_image')) {
    //             $url = $this->saveImage($request->file('vehicle_license_image'), "vehicles", rand(1000, 2555) . rand(1, 100) . rand(100, 1000));
    //             $vehicle->vehicle_license_image = $url;
    //         }
    //         $vehicle->update();
    //     } else {
    //         $vehicle = new Vehicle;
    //         $vehicle->driver_id      = $driver->id;
    //         $vehicle->vehicle_name      = $request->vehicle_name;
    //         $vehicle->vehicle_type      = $request->vehicle_type;
    //         $vehicle->vehicle_model      = $request->vehicle_model;
    //         $vehicle->vehicle_year      = $request->vehicle_year;
    //         $vehicle->plate_number      = $request->plate_number;
    //         $vehicle->motion_vector      = $request->motion_vector;
    //         $vehicle->horse_power      = $request->horse_power;
    //         $vehicle->vehicle_color      = $request->vehicle_color;
    //         $vehicle->kilometer_count = $request->kilometer_count;

    //         if ($request->file('vehicle_license_image')) {
    //             $url = $this->saveImage($request->file('vehicle_license_image'), "vehicles", rand(1000, 2555) . rand(1, 100) . rand(100, 1000));
    //             $vehicle->vehicle_license_image = $url;
    //         }

    //         if ($request->file('vehicle_image')) {
    //             $url = $this->saveImage($request->file('vehicle_image'), "vehicles", rand(1000, 2555) . rand(1, 100) . rand(100, 1000));
    //             $vehicle->vehicle_image = $url;
    //         }

    //         $vehicle->save();
    //     }
    //     return $this->returnSuccess("تم تعديل البيانات بنجاح");
    // }

    // public function License_data(Request $request)
    // {
    //     $token = $request->header('Authorization');

    //     if (Str::startsWith($token, "Bearer")) {
    //         $token = Str::substr($token, 7);
    //     }

    //     $driver = DriverModel::where("api_token", $token)->get()->first();

    //     if ($licence = License::where('driver_id', $driver->id)->first()) {

    //         if ($request->license_name) {
    //             $licence->license_name = $request->license_name;
    //         }
    //         if ($request->license_year) {
    //             $licence->license_year = $request->license_year;
    //         }
    //         if ($request->license_nationality) {
    //             $licence->license_nationality = $request->license_nationality;
    //         }
    //         if ($request->expiry_date) {
    //             $licence->expiry_date = $request->expiry_date;
    //         }

    //         if ($request->license_vehicle) {
    //             $licence->license_vehicle = $request->license_vehicle;
    //         }
    //         if ($request->license_number) {
    //             $licence->license_number = $request->license_number;
    //         }

    //         if ($request->file('license_image')) {
    //             $url = $this->saveImage($request->file('license_image'), "vehicles", rand(1000, 2555) . rand(1, 100) . rand(100, 1000));
    //             $licence->license_image = $url;
    //         }
    //         $licence->update();
    //     } else {
    //         $licence = new License;
    //         $licence->driver_id      = $driver->id;
    //         $licence->license_name      = $request->license_name;
    //         $licence->license_year      = $request->license_year;
    //         $licence->license_nationality      = $request->license_nationality;
    //         $licence->expiry_date      = $request->expiry_date;
    //         $licence->license_vehicle      = $request->license_vehicle;
    //         $licence->license_number      = $request->license_number;


    //         if ($request->file('license_image')) {
    //             $url = $this->saveImage($request->file('license_image'), "vehicles", rand(1000, 2555) . rand(1, 100) . rand(100, 1000));
    //             $licence->license_image = $url;
    //         }



    //         $licence->save();
    //     }
    //     return $this->returnSuccess("تم تعديل البيانات بنجاح");
    // }

    // public function identy_data(Request $request)
    // {
    //     $token = $request->header('Authorization');

    //     if (Str::startsWith($token, "Bearer")) {
    //         $token = Str::substr($token, 7);
    //     }

    //     $driver = DriverModel::where("api_token", $token)->first();


    //     if ($identity = Identity::where('driver_id', $driver->id)->first()) {

    //         if ($request->name) {
    //             $identity->name = $request->name;
    //         }
    //         if ($request->identity_number) {
    //             $identity->identity_number = $request->identity_number;
    //         }
    //         if ($request->license_nationality) {
    //             $identity->license_nationality = $request->license_nationality;
    //         }
    //         if ($request->expiry_date) {
    //             $identity->expiry_date = $request->expiry_date;
    //         }

    //         if ($request->nationality) {
    //             $identity->nationality = $request->nationality;
    //         }
    //         if ($request->birthday) {
    //             $identity->birthday = $request->birthday;
    //         }
    //         if ($request->religion) {
    //             $identity->religion = $request->religion;
    //         }

    //         if ($request->file('identity_image')) {
    //             $url = $this->saveImage($request->file('identity_image'), "vehicles", rand(1000, 2555) . rand(1, 100) . rand(100, 1000));
    //             $identity->identity_image = $url;
    //         }

    //         $identity->update();
    //     } else {
    //         $identity = new Identity;
    //         $identity->driver_id      = $driver->id;
    //         $identity->name      = $request->name;
    //         $identity->identity_number      = $request->identity_number;
    //         $identity->expiry_date      = $request->expiry_date;
    //         $identity->nationality      = $request->nationality;
    //         $identity->birthday      = $request->birthday;
    //         $identity->religion      = $request->religion;

    //         if ($request->file('identity_image')) {
    //             $url = $this->saveImage($request->file('identity_image'), "vehicles", rand(1000, 2555) . rand(1, 100) . rand(100, 1000));
    //             $identity->identity_image = $url;
    //         }

    //         $identity->save();
    //     }
    //     return $this->returnSuccess("تم تعديل البيانات بنجاح");
    // }

    // public function address_data(Request $request)
    // {
    //     $token = $request->header('Authorization');

    //     if (Str::startsWith($token, "Bearer")) {
    //         $token = Str::substr($token, 7);
    //     }

    //     $driver = DriverModel::where("api_token", $token)->get()->first();


    //     if ($address = DriverAddress::where('driver_id', $driver->id)->first()) {

    //         if ($request->name) {
    //             $address->name = $request->name;
    //         }
    //         if ($request->date) {
    //             $address->date = $request->date;
    //         }
    //         if ($request->registration_date) {
    //             $address->registration_date = $request->registration_date;
    //         }
    //         if ($request->description) {
    //             $address->description = $request->description;
    //         }



    //         if ($request->file('image')) {
    //             $url = $this->saveImage($request->file('image'), "vehicles", rand(1000, 2555) . rand(1, 100) . rand(100, 1000));
    //             $address->image = $url;
    //         }

    //         $address->update();
    //     } else {
    //         $address = new DriverAddress;
    //         $address->driver_id      = $driver->id;
    //         $address->name      = $request->name;
    //         $address->date      = $request->date;
    //         $address->registration_date      = $request->registration_date;
    //         $address->description      = $request->description;


    //         if ($request->file('image')) {
    //             $url = $this->saveImage($request->file('image'), "vehicles", rand(1000, 2555) . rand(1, 100) . rand(100, 1000));
    //             $address->image = $url;
    //         }

    //         $address->save();
    //     }
    //     return $this->returnSuccess("تم تعديل البيانات بنجاح");
    // }


    public function updateProfile(Request $request)
    {
        $valid = $this->validateUpdateRequest($request);
        if ($valid->fails()) {
            return $this->returnError($valid->errors()->first());
        }


        $token = $request->header('Authorization');
        if (Str::startsWith($token, "Bearer")) {
            $token = Str::substr($token, 7);
        }

        try {
            $driver = DriverModel::where("api_token", $token)->get()->first();
            if ($request->file('image')) {
                $imageUrl = $driver->image;
                File::delete($imageUrl);
                $url = $this->saveImage($request->file('image'), "drivers", $driver->id . rand(1, 100) . rand(100, 1000));
                $driver->image = $url;
            }
            if ($request->file('documents')) {
                $documents_url = $driver->documents;
                File::delete($documents_url);
                $url = $this->saveImage($request->file('documents'), "drivers", $driver->id . rand(1, 100) . rand(100, 1000));
                $driver->documents = $url;
            }
            if ($request->file('driving_license')) {
                $driving_license_url = $driver->driving_license;
                File::delete($driving_license_url);
                $url = $this->saveImage($request->file('driving_license'), "drivers", $driver->id . rand(1, 100) . rand(100, 1000));
                $driver->driving_license = $url;
            }
            if ($request->fullname) {
                $driver->fullname = $request->fullname;
            }
            if ($request->email) {
                $driver->email = $request->email;
            }
            if ($request->city_name) {
                $driver->city_name = $request->city_name;
            }
            if ($request->phone) {
                $driver->phone = $request->phone;
            }
            if ($request->city_id) {
                $driver->city_id = $request->city_id;
            }
            if ($request->transportation_id) {
                $driver->transportation_id = $request->transportation_id;
            }
            if ($request->lemozen_status || $request->lemozen_status == 0) {
                $driver->lemozen_status = (int)$request->lemozen_status;
            }
            if ($request->delivery_status || $request->delivery_status == 0) {
                $driver->delivery_status = (int)$request->delivery_status;
            }

            $driver->save();
            return $this->returnSuccess("تم تعديل البيانات بنجاح");


            return $this->returnSuccess("تم تعديل البيانات بنجاح");
        } catch (\Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }


    //report an emergency
    public  function reportEmergency(MakeEmergencyRequest $request)
    {

        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {

            $emergency = Emergency::create([
                'user_id' => $driver->id,
                'trip_id' => $request->trip_id,
                'type' => 'from driver',
            ]);

            return $this->returnData("تم التبليغ عن الرحله بنجاح");
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    //----------change password

    public function changePassword(Request $request)
    {
        $valid = $this->validateChangePasswordRequest($request);
        if ($valid->fails()) {
            return $this->returnError($valid->errors()->first());
        }
        $driver = GeneralHelper::currentDriver($request->header('Authorization'));
        if ($driver) {
            if ($request->password == $request->password_confirmation) {
                $driver->password = Hash::make($request->password);
                $driver->save();
                return $this->returnSuccess("تم تغيير كلمة المرور بنجاح");
            } else {
                return $this->returnError("كلمتي السر غير متطابقتين");
            }
        }
    }

    public function forgetPassword(Request $request)
    {
        $valid = $this->validateForgetPasswordRequest($request);
        if ($valid->fails()) {
            return $this->returnError($valid->errors()->first());
        }
        $driver = DriverModel::where('phone', $request->phone)->first();
        if ($driver) {
            if ($request->password == $request->password_confirmation) {
                $driver->password = Hash::make($request->password);
                $driver->save();
                return $this->returnSuccess("تم تغيير كلمة المرور بنجاح");
            } else {
                return $this->returnError("كلمتي السر غير متطابقتين");
            }
        } else {
            return $this->returnError("UnAuthorized");
        }
    }


    protected  function validateChangePasswordRequest(Request $request)
    {
        return validator()->make($request->all(), [
            "password" => "required|confirmed|min:6"
        ]);
    }

    protected  function validateForgetPasswordRequest(Request $request)
    {
        return validator()->make($request->all(), [
            "phone" => "required",
            "password" => "required|confirmed|min:6"
        ]);
    }
}
