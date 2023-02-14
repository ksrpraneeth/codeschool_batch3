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
            "gst_no" => ["unique:agencies,gst_no"]
        ];
    }

    public function messages()
    {
        return [
            "agency_name.min" => "Agency Name should be at least 3 characters",
            "agency_name.max" => "Agency Name should be at most 50 characters",

            "ifsc_code.digits" => "IFSC Code is invalid",
            "ifsc_code.exists" => "IFSC Code doesn't exists",

            "gst_no.unique" => "GST No Already Exists"
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
