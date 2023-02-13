<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    public function user_address(Request $request){
        $userId = Auth::user()->id;
        $data = UserAddress::where('id',$userId)->get();
        
        return response()->json(["status"=>true,"output"=>$data]);
    }
}
 