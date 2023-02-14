<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use App\Http\Requests\StoreAgencyRequest;
use App\Http\Requests\UpdateAgencyRequest;

class AgencyController extends Controller
{
    public function createAgency(StoreAgencyRequest $request)
    {
        try {
            Agency::create($request->all());
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

    public function getAgency(Agency $agency)
    {
        return response()->json([
            "status" => true,
            "message" => "Success",
            "data" => $agency
        ]);
    }
}
