<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\shop\LoginRequest;
use App\Models\admin\ShopModel;
use App\Models\shop;
use App\traits\ImageTrait;
use App\traits\ResonseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ShopLoginController extends Controller
{
    use ImageTrait;
    use ResonseTrait;

    public function showLoginForm()
    {

        return view("shop.login");
    }

    public function forgetPassword(Request $request)
    {
        $shop = ShopModel::where('phone', $request->phone)->first();
        if ($shop) {
            $shop->password = Hash::make($request->password);
            $shop->save();
            return redirect()->back()->with(["success" => "تم تغيير كلمة السر بنجاح"]);
        } else {
            return back()->withErrors(["not-found" => "عذرا انت غير مسجل فى نظام HMF"])->withInput($request->all());
        }
    }

    
    public function checkPhone(Request $request)
    {
        $shop = ShopModel::where('phone', $request->phone)->first();
        if ($shop) {
            return $this->returnSuccess('  المحل موجود');
            
        } else {
            return $this->returnError("  رقم الهاتف غير مُسجل من قبل  ");
        }
    }

    public function showHome()
    {
        return view("shop.home");
    }

    public function shopLogin(LoginRequest $request)
    {
        try {
            if (Auth::guard('shop')->attempt(['phone' => $request->phone, 'password' => $request->password, "active" => 1], $request->get('remember'))) {

                return redirect()->route('shop.home');
            } else {

                return back()->withErrors(["not-found" => "عذرا انت غير مسجل فى نظام HMF"])->withInput($request->all());
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with(["error" => "حدث خطأ ما برجاء المحاولة مره اخرى"]);
        }
    }


    public function getEditForm()
    {
        $user = ShopModel::find(Auth::id());
        return view("shop.editProfile", compact('user'));
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route("shop.login");
    }

    public function update(Request $request)
    {
        try {

            $user = Auth::user();
            $usernameChanged = false;
            $passwordChanged = false;
            $shopnameChanged = false;
            $phoneChanged = false;
            $addressChanged = false;
            $logoChanged = false;
            $time_chaged = false;
            $prepare_time_changed = false;
            $delivery_cost_channged = false;
            if ($user->username != $request->username && !empty($request->username)) {
                $usernameChanged = true;
            }
            if (Hash::check($request->password, $user->password) == false && !empty($request->password)) {
                $passwordChanged = true;
            }

            if ($user->name != $request->name && !empty($request->name)) {
                $shopnameChanged = true;
            }
            if ($user->phone != $request->phone && !empty($request->phone)) {
                $phoneChanged = true;
            }
            if ($user->address != $request->address && !empty($request->address)) {
                $addressChanged = true;
            }
            if ($request->file('logo')) {
                $logoChanged = true;
            }
            if ($request->open_at != $user->open_at || $request->close_at != $user->close_at) {
                $time_chaged = true;
            }
            if ($request->prepare_time != $user->prepare_time) {
                $prepare_time_changed = true;
            }
            if ($request->delivery_cost != $user->delivery_cost) {
                $delivery_cost_channged = true;
            }


            if ($usernameChanged || $passwordChanged || $phoneChanged || $shopnameChanged || $addressChanged || $logoChanged || $time_chaged || $prepare_time_changed || $delivery_cost_channged) {
                if (Hash::check($request->oldPassword, $user->password)) {
                    if ($usernameChanged) {
                        $user->username = $request->username;
                    }
                    if ($passwordChanged) {
                        if ($request->password == $request->confirmPassword) {
                            $user->password = Hash::make($request->password);
                        } else {
                            return redirect()->back()->with(['error' => "كلمتى السر غير متطابقتين"]);
                        }
                    }
                    if ($shopnameChanged) {
                        $user->name = $request->name;
                    }
                    if ($phoneChanged) {
                        $user->phone = $request->phone;
                    }
                    if ($addressChanged) {
                        $user->address = $request->address;
                    }
                    if ($time_chaged) {
                        $user->open_at = $request->open_at;
                        $user->close_at = $request->close_at;
                    }
                    if ($prepare_time_changed) {
                        $user->prepare_time = $request->prepare_time;
                    }
                    if ($delivery_cost_channged) {
                        $user->delivery_cost = $request->delivery_cost;
                    }
                    if ($logoChanged) {
                        $url = $this->saveImage($request->file('logo'), "shops/" . $user->id, 'logo');
                        $user->logo = $url;
                    }

                    $user->save();
                    return redirect()->back()->with(['success' => "تم تعديل البيانات بنجاح"]);
                } else {
                    return redirect()->back()->with(["error" => "كلمة السر القديمة خاطئه"]);
                }
            } else {
                return redirect()->back();
            }
        } catch (\Throwable $e) {
            return redirect()->back()->with(["error" => "حدث خطأ ما برجاء المحاولة مره اخرى"]);
        }
    }
}
