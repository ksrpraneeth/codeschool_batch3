<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function register(UserRegisterRequest $request){
        $userDetails = $request->all();

        // Creating new User
        $user = new User();
        $user->full_name = $userDetails["full_name"];
        $user->email = $userDetails["email"];
        $user->phone_number = $userDetails["phone_number"];
        $user->username = $userDetails["username"];
        $user->password = Hash::make($userDetails["password"]);

        // Saving Created User
        $user->save();

        // Sending Success message
        return response()->json([
            "status" => true,
            "message" => "Registration Successful!"
        ]);
    }

    function login(UserLoginRequest $request){
        $credentials = $request->all();

        // Getting user from database
        $user = User::where('username', $credentials["username"])->get();

        if($user)
    }
}
