<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    public function cheacklogin(LoginRequest $request){
        if(UserModel::where('email', $request->get('email'))->exists() && UserModel::where('password', $request->get('password'))->exists() ){
            return response()->json(["status"=>true,"message"=>'login succesfully',"Data"=>UserModel::where('email',$request->get('email'))->select('email','firstname','lastname','dob')->get()]);
        }
        else{
            return response()->json(["status"=>false,"message"=>'Invalid Credential']);
        }
    }
}
