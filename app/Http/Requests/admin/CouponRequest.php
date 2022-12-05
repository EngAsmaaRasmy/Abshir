<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
        $rules = [
            "name" => "required|unique:coupons,name",
            "type" => "required",
        ];
        $type = $this->request->get("type");
        if ($type == 1) {
            $rules['value'] = "required|numeric";

        } else if ($type == 2) {
            $rules['percentage'] = "required|numeric";
        }

        return $rules;
    }


    public function  messages()
    {
        return [
            "required"=>"هذا الحقل مطلوب",
            "name.unique"=>"هذا الكوبون مسجل من قبل",

        ];
    }
}
