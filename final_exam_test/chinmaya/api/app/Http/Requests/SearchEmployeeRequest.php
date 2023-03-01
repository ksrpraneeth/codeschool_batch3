<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchEmployeeRequest extends FormRequest
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
            "employeeId" => "required|regex:/^[a-zA-Z0-9]+$/",
        ];
    }

    public function messages()
    {
        return [
            "employeeId.required" => "Please provide the employee id",
            "employeeId.regex" => "No special characters are not allowed",
        ];
    }
}
