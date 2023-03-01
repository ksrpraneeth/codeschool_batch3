<?php

namespace App\Http\Controllers;

use App\Models\sport;
use Illuminate\Http\Request;

class sportstypeController extends Controller
{
    //
    public function SportsType(Request $request){
        $sportstype=sport::where('parent_id',$request->gameid)->get()->toarray();
        if(count($sportstype)==0){
            return response()->json(["status"=>false,"message"=>"No sports type available for this sports"]);
        }
        return response()->json(["status"=>true,"data"=>$sportstype]);
    }
}
