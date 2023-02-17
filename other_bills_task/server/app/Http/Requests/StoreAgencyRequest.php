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
            "ifsc_code" => ["required", "size:11", "exists:ifsc_codes,ifsc_code"],
            "gst_no" => ["size:15", "unique:agencies,gst_no"]
        ];
    }

    public function messages()
    {
        return [
            "agency_name.required" => "Please provide an Agency Name",
            "agency_name.min" => "The Agency Name should be between 3 and 50 characters",
            "agency_name.max" => "The Agency Name should be between 3 and 50 characters",

            "account_number.required" => "The Account Number is required",
            "account_number.min" => "The Account Number should be at least 5 characters",
            "account_number.unique" => "This Account Number is already exists. Please enter another",

            "ifsc_code.required" => "Please enter the IFSC Code",
            "ifsc_code.digits" => "The IFSC Code should be a valid 11-character alphanumeric code",
            "ifsc_code.exists" => "The IFSC Code is invalid. Please check and try again",

            "gst_no.size" => "The provided GST Number is not valid. Please ensure it is exactly 15 characters long",
            "gst_no.unique" => "The provided GST Number is already exists"
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
