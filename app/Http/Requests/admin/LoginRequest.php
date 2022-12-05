<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }
    public function messages()
    {
        return [

            'required' => 'هذا الحقل مطلوب'
        ];
    }
}
