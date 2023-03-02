<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAgencyRequest extends FormRequest
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
            "agency_name" => ["min:3", "max:50"],
            "ifsc_code" => ["size:11", "exists:ifsc_codes,ifsc_code"],
            "gst_no" => ["unique:agencies,gst_no", "size:15"]
        ];
    }

    public function messages()
    {
        return [
            "agency_name.min" => "The Agency Name should be between 3 and 50 characters",
            "agency_name.max" => "The Agency Name should be between 3 and 50 characters",

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
            "message" => $validator->errors()->first()
        ], 500));
    }
}
