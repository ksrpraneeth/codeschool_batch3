<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetIfscCodeDetailsRequest;
use App\Models\IfscCode;
use App\Http\Requests\StoreIfscCodeRequest;
use App\Http\Requests\UpdateIfscCodeRequest;

class IfscCodeController extends Controller
{
    public function getByCode(GetIfscCodeDetailsRequest $request)
    {
        try {
            $ifscCodeDetails = IfscCode::where(["ifsc_code" => $request->ifsc_code])->first();
            return response()->json([
                "status" => true,
                "message" => "Success",
                "data" => $ifscCodeDetails
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong!",
                "data" => $e->getMessage()
            ], 500);
        }
    }
}
