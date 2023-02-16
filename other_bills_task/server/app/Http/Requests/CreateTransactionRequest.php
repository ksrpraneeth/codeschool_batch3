<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateTransactionRequest extends FormRequest
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
            "form_type_id" => ["required", "exists:form_types,id"],
            "hoa" => ["required", "exists:head_of_accounts,hoa"],
            "reference_number" => ["required", "max:50"],
            "purpose" => ["required", "max:100"],
            "gross" => ["required", "numeric"],
            "pt" => ["required", "numeric"],
            "tds" => ["required", "numeric"],
            "gst" => ["required", "numeric"],
            "gis" => ["required", "numeric"],
            "thn" => ["required", "numeric"],
            "net" => ["required", "numeric"],
            // "bill_agencies" => ["required", "array:agency_name,agency_bank_name,agency_bank_branch,agency_ifsc_code,agency_account_number,agency_gst,gross,pt,tds,gst,gis,thn,net"],
            // "scrutiny_answers" => ["required", "array:desc,answer"],
        ];
    }

    public function messages()
    {
        return [
            "form_type_id.required" => "Form Type is required",
            "form_type_id.exists" => "Form Type doesn't exists",

            "hoa.required" => "Head of Account is required",
            "hoa.exists" => "Head of Account doesn't exists",

            "reference_number.required" => "Reference Number is required",
            "reference_number.max" => "Reference Number should be at most 50 characters",

            "purpose.required" => "Purpose is required",
            "purpose.max" => "Purpose should be at most 100 characters",

            "gross.required" => "Gross Amount is required",
            "gross.numeric" => "Gross Amount should be Number",

            "pt.required" => "PT Amount is required (>= 0)",
            "pt.numeric" => "PT Amount should be Number",

            "tds.required" => "TDS Amount is required (>= 0)",
            "tds.numeric" => "TDS Amount should be Number",

            "gst.required" => "GST Amount is required",
            "gst.numeric" => "GST Amount should be Number",

            "gis.required" => "GIS Amount is required",
            "gis.numeric" => "GIS Amount should be Number",

            "thn.required" => "Telangana Haritha Nidhi Amount is required",
            "thn.numeric" => "Telangana Haritha Nidhi Amount should be Number",

            "net.required" => "Net Amount is required",
            "net.numeric" => "Net Amount should be Number",

            // "bill_agencies.required" => "Bill Agencies is Required",
            // "bill_agencies.array" => "Agency missing details",

            // "scrutiny_answers.required" => "Scrutiny Answers is Required",
            // "scrutiny_answers.array" => "Scrutiny Answer missing details",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "status" => false,
            "message" => "Please check the errors",
            "data" => $validator->errors()
        ], 500));
    }
}
