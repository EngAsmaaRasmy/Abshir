<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use Illuminate\Http\JsonResponse;

class StoreCarDetailsRequest extends FormRequest
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
        // dd("aaaa");
        return [
            'license_number'=>'required',
            'expiry_date'=>'required',
            'car_marker'=>'',
            'car_model'=>'',
            'plate_number'=>'required',
            'vehicle_color'=>'required',
            'vehicle_license_image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'vehicle_license_image_back'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'vehicle_year' =>'required',
            'type' => 'required|'. Rule::in(['Car','Motorcycle']),
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
