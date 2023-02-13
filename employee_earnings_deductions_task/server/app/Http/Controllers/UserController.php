<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function get(Request $request)
    {
        $user = Auth::user();
        return [
            "status" => true,
            "message" => "Success",
            "data" => $user
        ];
    }

    function getModules()
    {
        try {
            $modules = UserModule::where('user_id', Auth::id())->with('module')->get()->pluck('module');
            return response()->json([
                "status" => true,
                "message" => "Success",
                "data" => $modules
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong",
                "data" => $e->getMessage()
            ]);
        }
    }

    function getEmployees()
    {
        try {
            $employees = Auth::user()->employees;
            return response()->json([
                "status" => true,
                "message" => "Success",
                "data" => $employees
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong",
                "data" => $e->getMessage()
            ]);
        }
    }
}
