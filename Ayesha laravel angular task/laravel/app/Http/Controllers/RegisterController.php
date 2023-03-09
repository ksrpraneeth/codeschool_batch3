<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
// use Firebase\JWT\JWT;
use App\Http\Requests\RegisterRequest;
use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Namshi\JOSE\JWT;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    public function registeruser(RegisterRequest $registerRequest)
    {
        if (Register::where('email', $registerRequest->get('email'))->exists()) {
            return response()->json(['status' => false, "message" => "Email already Exists"]);
        }
        if (Register::where('username', $registerRequest->get('username'))->exists()) {
            return response()->json(['status' => false, "message" => "Username already Exists"]);
        }

        $user = new Register();
        $user->full_name = $registerRequest->get('full_name');
        $user->email = $registerRequest->get('email');
        $user->username = $registerRequest->get('username');
        $user->password = Hash::make($registerRequest->get('password'));
        $user->save();

        return response()->json(['status' => true, "message" => "Registered Successfully"]);
    }
    public function loginuser(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->all();

        $token = Auth::attempt($credentials);
        //will go to config->auth.php where model is specified
        //runs select * from tablename where colnames=?
        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => true,
            'message' => 'Login Successful!',
            'user' => $user,
            // 'authorisation' => [
            'token' => $token,
            // 'type' => 'bearer',
            // ]
        ]);
    }

    public function dashboard(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        //checks if local storage token is equal to backend token
        if (!$user) {
            return response()->json(["status" => false, "message" => "Invalid user!"]);
        }
        return response()->json(["status" => true, "message" => "Valid user!"]);
    }
}
//     public function dashboard(Request $request) {
//         $header = $request->header('Authorization');
//         if ($header) {
//           $token = str_replace('Bearer ', '', $header);
//           try {
//             $decoded = JWT::decode($token,env('JWT_SECRET'), array('HS256'));
//             // Token is valid
//             return response()->json(['success' => true]);
//           } catch (\Exception $e) {
//             // Token is invalid
//             return response()->json(['success' => false], 401);
//           }
//         } else {
//           // No token found in header
//           return response()->json(['success' => false], 401);
//         }
//       }
// }


