<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CheckingAccountNumberRequest extends FormRequest
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
    public function rules()
    {
        return [
            "account_number" => ["required", "min:5", "exists:agencies,account_number"],
        ];
    }

    public function messages()
    {
        return [
            "account_number.required" => "Account Number is required",
            "account_number.min" => "Account Number should be at least 5 characters",
            "account_number.exists" => "Account Number doesn't exists",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "status" => false,
            "message" => $validator->errors()->first("account_number")
        ], 500));
    }
}
