<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest
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
            "name" => ["required", "min:5"],
            "email" => ["required", "email", "unique:App\Models\User,email"],
            "password" => ["required", "min:5"]
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Full Name is required!",
            "name.min" => "Full Name Should be at least 5 Characters",

            "email.required" => "Email is required",
            "email.email" => "Email is in invalid format",
            "email.unique" => "Email already exists!",

            "password.required" => "Password is required",
            "password:min" => "Password should be at least 5 characters"
        ];
    }

    protected function failedValidation(ValidationValidator $validator)
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
