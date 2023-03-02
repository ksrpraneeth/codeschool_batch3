<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(UserLoginRequest $request)
    {
        $credentials = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(["status" => false, "message" => "Username or Password is incorrect"], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            "status" => true,
            "message" => "User Registered Successfully"
        ]);
    }

    public function logout()
    {
        try{
            auth()->logout();
            return response()->json(['message' => 'Successfully logged out']);
        } catch(\Throwable $e){
            return response()->json(['message' => 'Successfully logged out']);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => true,
            'message' => "token",
            'data' => $token,
        ]);
    }
}
