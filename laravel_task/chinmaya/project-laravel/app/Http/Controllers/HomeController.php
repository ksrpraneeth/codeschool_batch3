<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use DB;
use App\Models\UserModel;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
    public function home(UserRequest $request){

        // dd($request->get('email'));
if(UserModel::where('email', $request->get('email'))->exists()){
    return response()->json(["status"=>false,"message"=>"user email already exists"]);
}
        
$user=new UserModel();
$user->email=$request->get('email');
$user->password=$request->get('password');
$user->firstname=$request->get('firstname');
$user->lastname=$request->get('lastname');
$user->dob=$request->get('dob');
$user->save();

return response()->json(['status' => true, "message" => "User Created Successfully"]);


        // $email = $request->email;
        // $password = $request->password;

        // DB::statement("INSERT into users(email,password) VALUES('$email','$password')");
        // DB::table('users')->insert([
        //     'email' => $email,
        //     'password' => $password
        // ]);

        // UserModel::insert([])

        // UserModel::create([
        //     'email' => $email,
        //     'password' => $password
        // ]);



    }
}
