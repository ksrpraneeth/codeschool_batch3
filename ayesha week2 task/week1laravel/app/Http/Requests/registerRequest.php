<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registerRequest extends FormRequest
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
            "fullName"=>'required|max:20',
            "email"=>'required|email',
            "username"=>'required|max:12',
            "password"=>'required|confirmed'
            //
        ];
    }
    public function messages()
    {
        //error messages to be written in front end
        return [
            "fullName.max"=>"Full name should not exceed 20 characters",
            "email.email"=>"Enter Valid email",
            "username"=>"Username should not exceed 12 characters",
            "password.confrimed"=>"Password and confirm password should be same"
        ];
    }
}
