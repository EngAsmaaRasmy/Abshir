<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
           "name-ar"=>"required|unique:categories,name_ar",
            "name-en"=>"required|unique:categories,name_en",
            "file"=>"required",
        ];
    }

    public function  messages()
    {
        return [
            "required"=>"هذا الحقل مطلوب",
            "name-ar.unique"=>"هذا القسم موجود بالفعل",
            "name-en.unique"=>"هذا القسم موجود بالفعل"
        ];
    }
}
