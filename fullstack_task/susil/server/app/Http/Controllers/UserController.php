<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function _construct(){
        $this->middleware('auth:api',['except'=>['login','register']]);
    }

public function register(UserRequest $request){

    try{

        if (UserModel::where('name', $request->get('name'))->exists()) {
            return response()->json(['status' => false, "message" => "Username is already present"]);
        }
    
        $user = new UserModel();
            $user->name = $request->get('name');
            $user->password = Hash::make($request->get('password'));
            
            $user->email = $request->get('email');
            
            $user->save();
            // 'password'=> Hash::make($request->password)
            $token=Auth::login($user);
            return response()->json(['status' => true, "message" => "User Created Successfully",'token'=>$token]);

    }catch(\Exception $e){

        return response()->json(['status' => false, "message" => $e->getMessage()]);

    }
}
public function login(LoginRequest $request){
    $cred=$request->only(['email','password']);
    $token=Auth::attempt($cred);
    $data=UserModel::where('email',$request->get('email'))->select('email','id')->get();
    
    if(!$token){
        return response()->json([
            'status'=>false,
            'message'=>'login failed'

        ]);
    }
        // return $data;
        return response()->json([
            'status'=>True,
            'message'=>'logged in Successfully',
            'Data'=>$data,
            'token'=>$token
            

        ]);
     
     

}

}
// "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9yZWdpc3RlciIsImlhdCI6MTY3NTY4MDk1OCwiZXhwIjoxNjc1Njg0NTU4LCJuYmYiOjE2NzU2ODA5NTgsImp0aSI6ImJGcWtWNXdDZkM2RU9oVGIiLCJzdWIiOjE0LCJwcnYiOiI0MWRmODgzNGYxYjk4ZjcwZWZhNjBhYWVkZWY0MjM0MTM3MDA2OTBjIn0.Jy-9nxRJfInRPbqXdBVtQSYLaUkDyU_gMF0BS_1EFsQ"