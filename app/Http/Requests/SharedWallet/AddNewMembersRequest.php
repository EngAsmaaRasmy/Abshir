<?php

namespace App\Http\Requests\SharedWallet;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class AddNewMembersRequest extends FormRequest
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
            'group_id'=> 'required',
            'members' => 'required|array',
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
