<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckingAccountNumberRequest;
use App\Models\Agency;
use App\Http\Requests\StoreAgencyRequest;
use App\Http\Requests\UpdateAgencyRequest;
use Illuminate\Http\Request;

class AgencyController extends Controller
{
    public function createAgency(StoreAgencyRequest $request)
    {
        try {
            Agency::create($request->validated());
            return response()->json([
                "status" => true,
                "message" => "Successfully Created"
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong!",
                "data" => $e->getMessage()
            ], 500);
        }
    }

    public function getAgencyByAcNo(CheckingAccountNumberRequest $request)
    {
        $agency = Agency::where(["account_number" => $request->account_number])->with("ifscCodeDetails")->first();
        return response()->json([
            'status' => true,
            "message" => "Agency Found",
            'data' => $agency,
        ]);
    }

    public function updateAgency(UpdateAgencyRequest $request, Agency $agency)
    {
        try {
            $agency->update($request->only(['agency_name', 'ifsc_code', 'gst_no']));
            return response()->json([
                "status" => true,
                "message" => "Updated Successfully"
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong!",
                "data" => $e->getMessage()
            ]);
        }
    }
}
