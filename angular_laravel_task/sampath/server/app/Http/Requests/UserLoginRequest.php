<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginRequest extends FormRequest
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
            "email" => ["required", "email", "exists:App\Models\User,email"],
            "password" => ["required", "min:5"]
        ];
    }

    public function messages(){
        return [
            "email.required" => "Email is required",
            "email.email" => "Email should be valid",
            "email.exists" => "Email doesn't exists",

            "password.required" => "Password is required",
            "password:min" => "Password should be at least 5 characters"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                "status" => false,
                "message" => "Please Check Errors",
                "data" => $validator->errors()
            ],
            422
        ));
    }
}
