<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registrationRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => 'required| max:25',
            'lastname' => 'required | max:25',
            'email' => 'required | email|unique:users,email',
            'password' => 'required | max:10',
            'phone' => 'required | max:10'
        ];

    }
    public function messages()
    {
        return [
            'firstname.required'=>'Invalid Data',
            'email.unique'=>'Email already exists',
            'password.required'=>'Please provide a password'
        ];
    }
   
}
