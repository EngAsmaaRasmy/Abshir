<?php

namespace App\Http\Requests\Driver;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\RequiredIf;

class StoreDocumentsRequest extends FormRequest
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
            'criminal_chip_image'=>new RequiredIf($this->contract_image == null,$this->examination_report != null ),
            'criminal_chip_image' =>'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'examination_report'=>new RequiredIf($this->contract_image == null,$this->criminal_chip_image != null),
            'examination_report' =>'image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'contract_image'=>new RequiredIf($this->criminal_chip_image == null,$this->examination_report == null),
            'contract_image' =>'image|mimes:jpeg,png,jpg,gif,svg|max:10240',

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
