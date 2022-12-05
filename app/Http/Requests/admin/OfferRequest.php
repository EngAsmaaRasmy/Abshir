<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
            "duration"=>"required|numeric",
            "image"=>"required"
        ];
    }

    public function  messages()
    {
        return [
            "required"=>"هذا الحقل مطلوب",
            "duration.numeric"=>"برجاء ادخال المده على شكل عدد الايام"
        ];
    }
}
