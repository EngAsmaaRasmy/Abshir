<?php

namespace App\Http\Requests\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class CancelTripRequest extends FormRequest
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
            'trip_id'=>'required',
            "cancellation_reason" => "required|",
            "after_3_minutes" =>'required|'. Rule::in([0,1])
        ];
    }

    public function  messages()
    {
        return [
            "required" => "هذا الحقل مطلوب",
            "in" =>'يجب ان يكون 0 او 1',

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
