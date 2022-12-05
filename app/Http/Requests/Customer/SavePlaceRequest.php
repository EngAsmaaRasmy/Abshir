<?php

namespace App\Http\Requests\Customer;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Helpers\GeneralHelper;

class SavePlaceRequest extends FormRequest
{
    public $customer;
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
    public function rules(Request $request)
    {
        $customer = GeneralHelper::currentCustomer($request->header('Authorization'));
        // dd($customer);

        return [
            'name' =>['required', Rule::unique('save_places')->where(function ($query) use ($customer) {
                return $query->where('customer_id', '=',$customer->id);
            })],
            'lat' =>'required',
            'lng' =>'required',
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
