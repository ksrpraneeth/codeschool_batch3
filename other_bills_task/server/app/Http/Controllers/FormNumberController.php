<?php

namespace App\Http\Controllers;

use App\Models\FormNumber;
use App\Models\FormType;
use Illuminate\Http\Request;

class FormNumberController extends Controller
{
    function getAll()
    {
        try {
            $formNumbers = FormNumber::all();
            return response()->json([
                "status" => true,
                "message" => "Success",
                "data" => $formNumbers
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong!",
                "data" => $e->getMessage()
            ]);
        }
    }

    function getFormTypes(FormNumber $formNumber)
    {

        return response()->json([
            "status" => true,
            "message" => "Success",
            "data" => $formNumber->formTypes
        ]);
    }

    function getHeadOfAccounts(FormType $formType){
        return response()->json([
            "status" => true,
            "message" => "Success",
            "data" => $formType->hoas
        ]);
    }
}
