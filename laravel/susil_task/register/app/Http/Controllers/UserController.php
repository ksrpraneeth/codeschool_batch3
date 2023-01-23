<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserModel;
use Illuminate\Support\Facades\Validator;
use DB;

class UserController extends Controller
{
public function user_register(UserRequest $request){
    // $data = [
    //     'name' => 'susil'
    // ];
    // return response()->json($data);
    if (UserModel::where('name', $request->get('name'))->exists()) {
        return response()->json(['status' => false, "message" => "Username is already present"]);
    }

    $user = new UserModel();
        $user->name = $request->get('name');
        $user->password = $request->get('password');
        
        $user->email = $request->get('email');
        
        $user->save();

        
        return response()->json(['status' => true, "message" => "User Created Successfully"]);
}
}
