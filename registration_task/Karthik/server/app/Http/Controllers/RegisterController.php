<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\UserModel;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register(UserRequest $request)
    {

        if (UserModel::where('email', $request->get('email'))->exists()) {
            return response()->json(['status' => false, "message" => "Email already Exists"]);
        }
        if (UserModel::where('phone_number', $request->get('phone_number'))->exists()) {
            return response()->json(['status' => false, "message" => "Phone Number already Exists"]);
        }

        $user = new UserModel();
        $user->full_name = $request->get('full_name');
        $user->email = $request->get('email');
        $user->phone_number = $request->get('phone_number');
        $user->password = $request->get('password');
        $user->dob = $request->get('dob');
        $user->save();

        return response()->json(['status' => true, "message" => "Registered Successfully"]);
    }
    public function Login(LoginRequest $loginRequest)
    {
        $user = UserModel::where('email', $loginRequest->get('email'))->get()->toArray();
        if (count($user) == 0) {
            return response()->json(['status' => false, 'message' => "Invalid Email"]);
        }
        if ($user[0]["password"] == $loginRequest->get("password")) {
            return response()->json(['status' => true, "message" => "Login Successful"]);
        }
        return response()->json(['status' => false, 'message' => "Invalid Password"]);
    }
}