<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'full_name' => 'required|max:20',
            'email' => 'required|email',
            'phone_number' => 'required|digits:10',
            'dob' => 'required|date',
            'password' => 'required|confirmed',
        ];
    }
    public function messages()
    {
        return [
            'full_name.max' => "Full Name Should be less than 20 characters",
            'email.email' => "Enter Valid Email",
            'phone_number.digits' => "Phone Number Should be 10 Digits",
            'dob.date' => 'Enter Valid Date',
            'password.confirmed' => 'Password and Confirm Password Should be Same'
        ];
    }
}