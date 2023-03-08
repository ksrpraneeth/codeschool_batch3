<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
 

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    

    public function register(UserRegisterRequest $request) {
        try {
            $userdata = new User;
            $userdata->fullname = $request->get('fullname');
            $userdata->phone = $request->get('phone');
            $userdata->email = $request->get('email');
            $userdata->password = Hash::make($request->get('password'));
            $userdata->save();
            return response()->json([
                "status" => true,
                "message" => "Registration Successfull"
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'false',
                'message' => 'Incorrect email or password',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'true',
                'message' => 'Login Successfull',
                'authorization' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
        ]);

    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'true',
            'message' => 'Successfully logged out',
        ]);
    }


    public function getUserDetails() {
        return Auth::user();
    }

    public function checkSession() {

        $user = JWTAuth::parseToken()->authenticate();
        return response()->json([
            'status' => 'true',
            'message' => $user
        ]);
        
    }

}