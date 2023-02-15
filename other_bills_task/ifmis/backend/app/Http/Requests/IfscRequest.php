<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IfscRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'ifsc_code'=>'required|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/'
        ];
    }
    public function messages()
    {
        return [
            'ifsc_code.regex'=>'Enter valid IFSC Code!',
        ];
    }
}
