<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            "full_name" => ["required", "min:5"],
            "email" => ["required", "email", "unique:App\Models\User,email"],
            "phone_number" => ["required", "numeric","digits:10", "unique:App\Models\User,phone_number"],
            "username" => ["required", "min:5", "max:25", "unique:App\Models\User,username"],
            "password" => ["required", "min:5"]
        ];
    }

    public function messages()
    {
        return [
            "full_name.required" => "Full Name is required!",
            "full_name.min" => "Full Name Should be at least 5 Characters",

            "email.required" => "Email is required",
            "email.email" => "Email is in invalid format",
            "email.unique" => "Email already exists!",

            "phone_number.required" => "Phone Number is required",
            "phone_number.numeric" => "Phone Number should contain only numbers",
            "phone_number.digits" => "Phone Number should be 10 characters",
            "phone_number.unique" => "Phone Number already exists",

            "username.required" => "Username is required",
            "username.min" => "Username should be at least 5 characters",
            "username.max" => "Username should be max of 25 characters",
            "username.unique" => "Username already exists",

            "password.required" => "Password is required",
            "password:min" => "Password should be at least 5 characters"
        ];
    }
}
