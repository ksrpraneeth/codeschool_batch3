<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
            "name" => ["required", "min:5", "max:25"],
            "email" => ["required", "email", "unique:App\Models\Employee,email"],
            "phone" => ["required", "digits:10", "unique:App\Models\Employee,phone"],
            "dob" => ["required", "date"],
            "position" => ["required", "min:2", "max:25"],
            "salary" => ["required", "integer", "min_digits:1", "max_digits:10"],
            "gender" => ["required", Rule::in(["male", "female"])]
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "Name is required",
            "name.min" => "Name should be at least 5 characters",
            "name.max" => "Name should be at most 25 characters",

            "email.required" => "Email is required",
            "email.email" => "Email is invalid",
            "email.unique" => "Email already Exists",

            "phone.required" => "Phone Number is required",
            "phone.digits" => "Phone Number must be 10 characters",
            "phone.unique" => "Phone Number Already Exists",

            "dob.required" => "Data of Birth is required",
            "dob.date" => "Data of Birth must be a date",

            "position.required" => "Position is required",
            "position.min" => "Position must be at least 2 Characters",
            "position.max" => "Position must be at most 25 Characters",

            "salary.required" => "Salary is required",
            "salary.integer" => "Salary is invalid",
            "salary.min_digits" => "Salary must be at least 0",
            "salary.max_digits" => "Salary must be at most 999999999",

            "gender.required" => "Gender is required",
            "gender.in" => "Gender must be male or female",

        ];
    }
}