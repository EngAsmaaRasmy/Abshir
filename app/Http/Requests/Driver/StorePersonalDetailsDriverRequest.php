<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;

class StorePersonalDetailsDriverRequest extends FormRequest
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
            'date_of_birth'=>'required|date',
            'identity_number'=>'required|integer',
            'identity_image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'identity_image_back'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'gender'=>'required|'. Rule::in(['Male','Female']),
            'license_number'=>'required|integer',
            'expiry_date'=>'required|date',
            'driving_license'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'driving_license_back'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',

        ];
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {

        $response = new JsonResponse([
            "status" => false,
            "error" => $validator->errors(),
            "message" => "",
            'data' => []
        ]);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
