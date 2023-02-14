<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAgencyRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "agency_name" => ["required", "min:3", "max:50"],
            "account_number" => ["required", "min:5", "unique:agencies,account_number"],
            "ifsc_code" => ["required", "size:11", "exists:ifsc_codes,ifsc_code"]
        ];
    }

    public function messages()
    {
        return [
            "agency_name.required" => "Agency Name is required",
            "agency_name.min" => "Agency Name should be at least 3 characters",
            "agency_name.max" => "Agency Name should be at most 50 characters",

            "account_number.required" => "Account Number is required",
            "account_number.min" => "Account Number should be at least 5 characters",
            "account_number.unique" => "Account Number already exists",

            "ifsc_code.required" => "IFSC Code is required",
            "ifsc_code.digits" => "IFSC Code is invalid",
            "ifsc_code.exists" => "IFSC Code doesn't exists"
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "status" => false,
            "message" => "Please check the errors",
            "data" => $validator->errors()
        ], 500));
    }
}
