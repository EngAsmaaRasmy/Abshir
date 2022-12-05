<?php

namespace App\Http\Controllers\api;

use App\Helpers\GeneralHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\api\AuthenticationRequest;
use App\Http\Requests\Emergency\MakeEmergencyRequest;
use App\Models\AppConfiguration;
use App\Models\Customer;
use App\Models\Emergency;
use App\Models\Wallet;
use App\traits\IDs;
use App\traits\ImageTrait;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\This;
use Tymon\JWTAuth\Claims\Custom;

class AuthController extends Controller
{

    use ResonseTrait;
    use ImageTrait;
    use IDs;

    public function login()
    {
    }
    public function update_location(request $request)
    {
        try {
            $customer = Customer::find($request->user_id);

            if ($request->longitude) {
                $customer->longitude = $request->longitude;
            }
            if ($request->latitude) {
                $customer->latitude = $request->latitude;
            }

            $customer->save();
            return $this->returnSuccess("تم التعديل بنجاح");
        } catch (\Throwable $e) {
            return $this->returnException();
        }
    }

    public function register(Request $request)
    {

        try {

            $valid = $this->validateRegisterRequest($request);
            if ($valid->fails()) {
                return $this->returnError($valid->errors()->first());
            }


            $url = '';

            if ($request->file('file')) {
                $id = $this->getNextId("customers");
                $url = $this->saveImage($request->file('file'), 'customers', $id);
            }

            $customer = Customer::where('phone', $request->phone)->first();
            if ($customer) {
                $customer->uid = $request->uid;
                $customer->fcm_token = $request->fcm_token;
                $customer->name = $request->name;
                $customer->save();
                
                $wallet = Wallet::where('customer_id', $customer->id)->first();
                    if(!$wallet){
                        $wallet = Wallet::create([
                            'customer_id' => $customer->id,
                            'wallet_balance' => '0'
                        ]);
                    }
                return $this->returnData($customer, "هذا الهاتف موجود بالفعل");
            } else {
                Customer::create([
                    "phone" => $request->phone,
                    'name' => $request->name,
                    "uid" => $request->uid,
                    "api_token" => Str::random(60),
                    "fcm_token" => $request->fcm_token,
                    "image" => $url,
                ]);
                // $customer = Customer::firstOrCreate(
                //     ["phone" => $request->phone],
                //     [
                //         'name' => $request->name,

                //         "uid" => $request->uid,
                //         "api_token" => Str::random(60),
                //         "fcm_token" => $request->fcm_token,
                //         "image" => $url
                //     ]
                // );

                $wallet = Wallet::create([
                    'customer_id' => $customer->id,
                    'wallet_balance' => '0'
                ]);
            }

            return $this->returnData($customer, "تم التسجيل بنجاح");
        } catch (\Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function check(Request $request)
    {
        try {
            $user = Customer::where("uid", $request->uid)->first();

            if (!$user) {
                return $this->returnData(null, "غير موجود");
            } else if ($user->active == 0) {
                return $this->returnError("تم الغاء تفعيل حسابك من ادارة التطبيق برجاء مراجعة الدعم الفنى");
            } else {
                $config = AppConfiguration::all();
                $token = $request->fcm_token;
                if ($token && $token != $user->fcm_token) {
                    $user->update([
                        "fcm_token" => $token
                    ]);
                }
                return $this->returnData(["user" => $user, "config" => $config], "");
            }
        } catch (\Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function refreshToken(Request $request)
    {
        try {
            $customer = Customer::find($request->user_id);
            $customer->update([
                "fcm_token" => $request->token
            ]);

            return $this->returnSuccess("تم تحديث التوكين بنجاح");
        } catch (\Throwable $e) {
            return $this->returnException();
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $customer = Customer::find($request->user_id);
            $imageUrl = null;
            if ($request->file('file')) {
                $imageUrl = $customer->image;
                File::delete($imageUrl);
                $url = $this->saveImage($request->file('file'), "customers", $customer->id);
                $customer->image = $url;
            }
            if ($request->name) {
                $customer->name = $request->name;
            }
            $customer->save();
            return $this->returnData(["url" => $imageUrl], "");
        } catch (\Throwable $e) {
            return $this->returnException();
        }
    }

    public function initApp()
    {
        try {
            $configs = AppConfiguration::query()->get();
            return $this->returnData($configs);
        } catch (\Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function profile(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {
            $customer = Customer::select(
                'customers.id',
                'customers.name',
                'wallets.wallet_balance'
            )
                ->leftjoin('wallets', 'wallets.customer_id', 'customers.id')
                ->where('customers.id', $customer->id)->first();

            $customer->wallet_balance = number_format((float)$customer->wallet_balance , 2);
            return $this->returnData($customer, "Fetch Customer Data successfully");
        } else {
            return $this->returnError("UnAuthorized");
        }
    }

    public function validateRegisterRequest(Request $request)
    {
        return validator()->make($request->all(), [
            "name" => "required",
            "phone" => "required ",
            "uid" => "required| ",
            "fcm_token" => "required",
        ], [

            "name.required" => "محتاجين نعرف اسمك عشان نقدر نخدمك بشكل افضل",
            "phone.required" => "محتاجين نعرف رقمك عشان نقدر نخدمك بشكل افضل",
            "required" => "بعض المعلومات المطلوبه مفقوده",
            "unique" => "البيانات اللى دخلتها مسجله بالفعل"

        ]);
    }

    //report an emergency
    public  function reportEmergency(MakeEmergencyRequest $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {

            $emergency = Emergency::create([
                'user_id' => $customer->id,
                'trip_id' => $request->trip_id,
                'type' => 'from customer',
            ]);

            return $this->returnData("تم التبليغ عن الرحله بنجاح");
        } else {
            return $this->returnError("Unauthoried");
        }
    }

    public function sendCodeToEmail(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer) {

            $verification_code = Str::random(6);
            $sendEmail = Mail::send('emails.validate_email', ['verification_code' => $verification_code], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Email Verification');
 
            });

            $customer->verification_code = $verification_code;
            $customer->save();

            return $this->returnSuccess('تم ارسال الكود بنجاح');
        } else {
            return $this->returnError("Unauthoried");
        }

    }
    public function updateEmail(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        if ($customer && $customer->verification_code == $request->verification_code) {
            $customer->email = $request->email;
            $customer->save();
            return $this->returnData($customer,'تم اضافه الايميل بنجاح');

        } else {
            return $this->returnError("Unauthoried");
        }
    }
}
