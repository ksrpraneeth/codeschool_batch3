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
        return  [
            'username' => 'required|max:12',
            'email'=>'required|email',
            'password'=>'required|confirmed',
            'dob'=>'required|date'
        ];
    }
    public function messages()
    {
        return [
            'dob.date'=>"Date of Birth format is wrong",
            'password.confirmed'=>"Password and Confirm Password should be same"
        ];
    }
}
