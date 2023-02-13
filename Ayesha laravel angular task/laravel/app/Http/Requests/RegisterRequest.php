<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
                "full_name"=>'required|max:20',
                "email"=>'required|email',
                "username"=>'required|max:12',
                "password"=>'required|confirmed'
            ];
        }
        public function messages()
        {
            //error messages to be written in front end
            return [
                "full_name.max"=>"Full name should not exceed 20 characters",
                "email.email"=>"Enter Valid email",
                "username"=>"Username should not exceed 12 characters",
                "password.confirmed"=>"Password and confirm password should be same"
            ];
        }
    }
