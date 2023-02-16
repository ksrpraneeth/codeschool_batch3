<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgencyRequest extends FormRequest
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
            'agency_name'=>'required|min:4',
            'account_number'=>'required|min:12|max:22|confirmed',
            'ifsc_code'=>'required'
        ];
    }
    public function messages()
    {
        return [
            'agency_name.min'=>'Agency name should be atleast 4 characters.',
            'account_number.min'=>'Bank account number should be between 12-22 characters.',
            'account_number.max'=>'Bank account number should be between 12-22 characters.',
            'account_number.confirmed'=>'Bank account numbers do not match'
        ];
    }
}
