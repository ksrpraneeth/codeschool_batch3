<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Address;
use App\Models\User;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class UserController extends Controller
{
    public function register(UserRequest $request)
    {
        //\DB::enableQueryLog();
       /* dd(DB::select(DB::raw("select u.username,a.city,a.flat from users as u , addresses as a where u.id = a.user_id and u.id =4;")));*/
        if (UserModel::where('username', $request->get('username'))->exists()) {
            return response()->json(['status' => true, "message" => "Username is already present"]);
        }
        $user = new UserModel();
        $user->username = $request->get('username');
        $user->password = $request->get('password');
        $user->dob = $request->get('dob');
        $user->email = $request->get('email');
        $user->fullname = $request->get('fullname');
        $user->save();

        $addressArray  = $request->get('address');
        foreach ($addressArray as $addressEle) {
            $address = new Address();
            $address->user_id = $user->id;
            $address->city = $addressEle['city'];
            $address->flat = $addressEle['flat'];
            $address->save();
        }


        // dd(\DB::getQueryLog());

        //dd(UserModel::get()->toArray());

        return response()->json(['status' => true, "message" => "User Created Successfully"]);
    }
    public function getUser($id){

        return response()->json(UserModel::where('id',$id)->with('address')->select('id','username','dob','email')->get()->toArray());
    }
}
