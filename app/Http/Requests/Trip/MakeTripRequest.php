<?php

namespace App\Http\Requests\Trip;
use Illuminate\Http\JsonResponse;


use Illuminate\Foundation\Http\FormRequest;

class MakeTripRequest extends FormRequest
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
            "start_lat" => "required|",
            "start_long" => "required|",
            "end_lat" => "required|",
            "end_long" => "required|",
            "price_list_id" =>'required',
            "type_of_payment" => 'required',
            'pay_history_id'     => 'required_if:type_of_payment,3',
            'customer_contact_id'    => 'required_if:type_of_payment,4',
            'type'    => 'required_if:type_of_payment,4'

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
