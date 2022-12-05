<?php

namespace App\Http\Controllers;

use App\Http\Requests\admin\CouponRequest;
use App\Models\admin\ShopModel;
use App\Models\Coupon;
use App\Models\CouponType;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::paginate(PAGINATION);


        return view("admin.coupons.all", compact("coupons"));
    }

    public function getAddForm()
    {
        $couponTypes = CouponType::all();
        $shops = ShopModel::where("active", 1)->get();
        return view("admin.coupons.add", compact("couponTypes", "shops"));
    }

    public function save(Request $request)
    {
        try {
            $couponObj = [
                "name" => $request->input("name"),
                "type" => $request->input("type"),
                "value" => $request->input("value"),
                "percentage" => $request->input("percentage"),
                "max_count" => $request->input("max_count"),
                "expire_date" => $request->input("expire_date"),
                "minimum_order" => $request->input("minimum_order") ?? 0,

            ];
            $coupon = Coupon::create($couponObj);

            return redirect()->back()->with(['success' => "تم اضافة الكوبون بنجاح"]);
        } catch (\Throwable $e) {
            return redirect()->back()->with(['error' =>$e->getMessage()]);
        }

    }


    public function getUpdateForm($id)
    {

        $coupon = Coupon::find($id);
        $couponTypes = CouponType::all();
        $shops = ShopModel::where("active", 1)->get();
        return view("admin.coupons.edit", compact("coupon", "shops", "couponTypes"));
    }

    public function update(Request $request, $id)
    {
        try {
            $coupon = Coupon::find($id);
            $valid=$this->validateUpdateRequest($request,$coupon->name);
            if($valid->fails()){
                return redirect()->back()->withErrors($valid->errors());
            }else {
                $input = $request->all();
                $coupon->fill($input)->save();
                return redirect()->back()->with(['success' => "تم تعديل الكوبون بنجاح"]);
            }
            } catch (\Throwable $e) {
            return redirect()->back()->with(['error' => "حدث خطأ ما يرجاء المحاولة مرة اخرى"]);
        }
    }


    public function delete($id)
    {
        try {
            $coupon = Coupon::where("id", $id)->get()->first();
            $coupon->delete();
            return redirect()->back()->with(['success' => "تم حذف الكوبون بنجاح"]);
        } catch (\Throwable $e) {
            return redirect()->back()->with(["error" => $e->getMessage()]);
        }
    }

    public function validateUpdateRequest(Request $request, $name)
    {
        $rules = [
            "type"=>"required"
        ];
        if ($request->name != $name) {
            $rules["name"]="required";
        }


        $type = $request->input("type");
        if ($type == 1) {
            $rules['value'] = "required|numeric";

        } else if ($type == 2) {
            $rules['percentage'] = "required|numeric";
        }
        return validator()->make($request->all(), $rules, ["required" => "هذا الحقل مطلوب", "unique" => "هذا الكوبون مسجل بالفعل"]);
    }


}
