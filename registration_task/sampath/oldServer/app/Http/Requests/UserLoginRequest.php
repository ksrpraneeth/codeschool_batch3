<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            "username" => ["required", "min:5", "exists:App\Models\User,username"],
            "password" => ["required", "min:5"]
        ];
    }

    public function messages(){
        return [
            "username.required" => "Username is required",
            "username.min" => "Username should be minimum of 5 characters",
            "username.exists" => "Username doesn't exists",

            "password.required" => "Password is required",
            "password:min" => "Password should be at least 5 characters"
        ];
    }
}
