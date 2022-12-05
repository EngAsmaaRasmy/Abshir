<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
{
    /**
     * @var mixed
     */

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "username"=>"required|unique:shops,username",
            "name"=>"required",
            "password"=>"required",
            "phone"=>"required|unique:shops,phone",
            "address"=>"required",
            // "active"=>"required",
            // "logo"=>"required",
            // "open_at"=>"required",
            // "close_at"=>"required",

        ];
    }

    public function  messages()
    {
        return [
            "required"=>"هذا الحقل مطلوب",
            "phone.unique"=>"هذا الهاتف موجود بالفعل",
            "username.unique"=>"اسم المستخدم موجود بالفعل",
            "phone.max phone.min"=>"برجاء ادخال رقم هاتف صحيح مكون من 11 رقم"
        ];
    }
}
