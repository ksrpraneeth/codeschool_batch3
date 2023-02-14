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
