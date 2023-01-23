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
    public function login_check(LoginRequest $request){
if(UserModel::where('email',$request->get('email'))->exists() && UserModel::where('password',$request->get('password'))->exists()){
return response()->json(["status"=>true,"message"=>'login successfully','Data'=>UserModel::where('email',$request->get('email'))->select('email')->get()]);
}
else{
    return response()->json(["status"=>false,"message"=>'Invalid Credential']);
}
    }
} 
   