<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetIfscCodeDetailsRequest extends FormRequest
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
            "ifsc_code" => ["required", "size:11", "exists:ifsc_codes,ifsc_code"]
        ];
    }

    public function messages()
    {
        return [
            "ifsc_code.required" => "Please provide the IFSC Code",
            "ifsc_code.digits" => "The IFSC Code should be an 11-character alphanumeric code",
            "ifsc_code.exists" => "The IFSC Code provided is not valid. Please double-check and try again"
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
