<?php

namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;
use DB;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
if(UserModel::where('email',$request->get('email'))->exists() && UserModel::where('password',$request->get('password'))->exists()){
    
    $data=UserModel::where('email',$request->get('email'))->select('email','id')->get();
    // $token=$data->createToken('mytoken')->plainTextToken;
return response()->json(["status"=>true,"message"=>'login successfully','Data'=>$data]);
}
else{
    return response()->json(["status"=>false,"message"=>'Invalid Credential']);
}
// $data=$request->input();
// $request->session()->put('user',$data);
// echo session('user');
    }
    
} 

   