<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\registrationRequest;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class userController extends Controller
{
  

    public function login(Request $request)
    {
       
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        
        return response()->json([
            'status' => true,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ]);
    }

    public function Register(registrationRequest $request)
    {
        // dd($request->all()['email']);
        // dd($request->email);

        $user = new user();
        $user->email = $request->get('email');
        $user->password = Hash::make($request->password);
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->phone = $request->phone;
        $user->save();

        return response()->json(['status' => true, "message" => "Registration Succeesfull"]);

    }

    public function Logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}
