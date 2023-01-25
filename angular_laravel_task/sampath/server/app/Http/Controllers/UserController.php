<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function get(Request $request){
        $user = Auth::user();
        return [
            "status" => true,
            "message" => "Success",
            "data" => $user
        ];
    }
}
