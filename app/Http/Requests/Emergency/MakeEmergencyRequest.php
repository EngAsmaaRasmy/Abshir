<?php

namespace App\Http\Requests\Emergency;
use Illuminate\Http\JsonResponse;


use Illuminate\Foundation\Http\FormRequest;

class MakeEmergencyRequest extends FormRequest
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
            "trip_id" => "required|",
        ];
    }
    public function  messages()
    {
        return [
            "required"=>"هذا الحقل مطلوب",

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
