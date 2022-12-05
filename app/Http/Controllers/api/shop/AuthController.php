<?php

namespace App\Http\Controllers\api\shop;

use App\Http\Controllers\Controller;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ResonseTrait;


    public function checkToken(Request $request)
    {
        try {

            $user = auth('shop-api')->user();
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
            $cred = $request->only(["username", "password"]);
             if($token=Auth::guard('shop-api')->attempt($cred)){
                $user= auth('shop-api')->user()->append('token');
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

    public function logout(){
        try {
            auth('shop-api')->logout();
            return $this->returnSuccess();
        }
        catch (Throwable $e){
            return $this->returnError($e->getMessage());
        }
    }
}
