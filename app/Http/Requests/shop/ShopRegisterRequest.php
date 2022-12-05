<?php

namespace App\Http\Requests\shop;

use Illuminate\Foundation\Http\FormRequest;

class ShopRegisterRequest extends FormRequest
{
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
            "name"=>"required",
            "password"=>"required",
            "phone"=>"required|min:11|unique:shops,phone",
            "address"=>"required",
            "logo"=>"required",
            "open_at"=>"required",
            "close_at"=>"required",
            'category' => 'required'

        ];
    }

    public function  messages()
    {
        return [
            "required" => "هذا الحقل مطلوب",
            "phone.unique" => "هذا الهاتف موجود بالفعل",
            "username.unique" => "اسم المستخدم موجود بالفعل",
            "phone.max phone.min" => "برجاء ادخال رقم هاتف صحيح مكون من 11 رقم"
        ];
    }
}
