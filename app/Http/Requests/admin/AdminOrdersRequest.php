<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminOrdersRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            "details"=>"required",
            // "driver_id"=>"required",
            "customer_address"=>"required",
            "customer_name"=>"required",
            "customer_phone"=>"required|min:11|max:11",
            // "delivery_cost"=>"required",
            // "must_paid"=>"required"
        ];
    }

    public function  messages()
    {
        return [
            "required"=>"هذا الحقل مطلوب",
            "customer_phone.min"=>"برجاء ادخال رقم هاتف صالح",
            "customer_phone.max"=>"برجاء ادخال رقم هاتف صالح",

        ];
    }
}
