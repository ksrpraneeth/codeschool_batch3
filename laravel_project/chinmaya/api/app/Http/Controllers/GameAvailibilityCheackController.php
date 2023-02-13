<?php

namespace App\Http\Controllers;

use App\Models\gameground;
use Illuminate\Http\Request;

class gameAvailibilityCheackController extends Controller
{
    //
    public function GameAvailable(Request $request){
        if(gameground::where('ground_id',$request->stadiumid)->where('sport_id',$request->gameid)->exists()){
            return response()->json(["status"=>true,"message"=>"Game available"]);
        }
        return response()->json(["status"=>false,"message"=>"Game is not available in this ground"]);
    }
}
