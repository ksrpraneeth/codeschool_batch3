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
            "ifsc_code.required" => "Please provide the IFSC code.",
            "ifsc_code.digits" => "Invalid IFSC code provided.",
            "ifsc_code.exists" => "The provided IFSC code does not exist in our records.",

            "form_type_id.required" => "Please select a form type.",
            "form_type_id.exists" => "The selected form type does not exist in our records.",

            "hoa.required" => "Please select a head of account.",
            "hoa.exists" => "The selected head of account does not exist in our records.",

            "reference_number.required" => "Please provide the reference number.",
            "reference_number.max" => "The reference number cannot be longer than 50 characters.",

            "purpose.required" => "Please provide the purpose of the transaction.",
            "purpose.max" => "The purpose of the transaction cannot be longer than 100 characters.",

            "gross.required" => "Please provide the gross amount of the transaction.",
            "gross.numeric" => "The gross amount must be a valid number.",

            "pt.required" => "Please provide the PT amount of the transaction.",
            "pt.numeric" => "The PT amount must be a valid number.",

            "tds.required" => "Please provide the TDS amount of the transaction.",
            "tds.numeric" => "The TDS amount must be a valid number.",

            "gst.required" => "Please provide the GST amount of the transaction.",
            "gst.numeric" => "The GST amount must be a valid number.",

            "gis.required" => "Please provide the GIS amount of the transaction.",
            "gis.numeric" => "The GIS amount must be a valid number.",

            "thn.required" => "Please provide the Telangana Haritha Nidhi amount of the transaction.",
            "thn.numeric" => "The Telangana Haritha Nidhi amount must be a valid number.",

            "net.required" => "Please provide the net amount of the transaction.",
            "net.numeric" => "The net amount must be a valid number."

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
