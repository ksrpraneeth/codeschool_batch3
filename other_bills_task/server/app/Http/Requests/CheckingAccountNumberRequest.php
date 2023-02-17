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
            "account_number.required" => "Please enter your account number.",
            "account_number.min" => "Your account number must be at least 5 characters long.",
            "account_number.exists" => "The account number you entered does not match our records. Please double-check and try again."
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
