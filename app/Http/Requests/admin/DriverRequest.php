<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class DriverRequest extends FormRequest
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

            "fullname"=>"required",
            "password"=>"required",
            "phone"=>"required|unique:drivers,phone|max:11|min:11",
            "address"=>"required",
            "active"=>"required"
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
