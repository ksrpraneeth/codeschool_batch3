<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\registerRequest;
use App\Models\registerModel;
use Illuminate\Http\Request;

class registerController extends Controller
{
    public function registerUsers(registerRequest $registerRequest)
    {
        if (registerModel::where('email', $registerRequest->get('email'))->exists()) {
            return response()->json(['status' => false, "message" => "Email already Exists"]);
        }
        if (registerModel::where('username', $registerRequest->get('username'))->exists()) {
            return response()->json(['status' => false, "message" => "Username already Exists"]);
        }

        $user = new registerModel();
        $user->fullName = $registerRequest->get('fullName');
        $user->email = $registerRequest->get('email');
        $user->username = $registerRequest->get('username');
        $user->password = $registerRequest->get('password');
        $user->save();

        return response()->json(['status' => true, "message" => "Registered Successfully"]);
    }
    public function Login(LoginRequest $LoginRequest)
    {
        $user = registerModel::where('username', $LoginRequest->get('username'))->get()->toArray();
        //dd($user);
        //dd($LoginRequest);
        if (count($user) == 0) {
            return response()->json(['status' => false, 'message' => "Invalid username"]);
        }
        if ($user[0]["password"] == $LoginRequest->get("password")) {
            return response()->json(['status' => true, "message" => "Login Successful"]);
        }
        return response()->json(['status' => false, 'message' => "Invalid Password"]);
    }
}
    
