<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiAuthController extends Controller
{

    use ResonseTrait;

    public function checkToken(Request $request)
    {
        try {

            $user = auth('admin-api')->user();

            if ($user) {

                $user->update(['fcm_token'=>$request->input('fcm_token')]);
                return $this->returnData(["user" => $user->append('token')]);

            }else
                return $this->returnError('هدا المستخدم غير موجود');
        } catch (JWTException $e) {
            return $this->returnError('هذا المستخدم غير موجود');
        } catch (Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function login(Request $request)
    {
        try {
            $cred = $request->only(["email", "password"]);
            if($token=Auth::guard('admin-api')->attempt($cred)){
                $user= auth('admin-api')->user()->append('token');
                $user->update(['fcm_token'=>$request->input('fcm_token')]);
                return $this->returnData(['user'=>$user]);
            }
            else{
                return $this->returnError('البريد الاليكترونى او كلمة السر غير صحيحة');
            }

        } catch (Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }
}
