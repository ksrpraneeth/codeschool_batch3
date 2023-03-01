<?php

namespace App\Http\Controllers;

use App\Models\gameground;
use App\Models\sport;
use App\Models\ground;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashbordController extends Controller
{
    //dashbord
    public function dashbord(Request $request){
  return response()->json(["status"=>true,"username"=>Auth::user()->firstname.' '.Auth::user()->lastname ]);

    }

    public function allStadium(){
     
      $stadium=ground::get()->toarray();
      return response()->json(["status"=>true,"data"=>$stadium]);
    }


    public function Sports(Request $request){
      $games=gameground::join('sports','gamegrounds.sport_id','=','sports.id')
      ->select('gamegrounds.*','sports.*')
      ->where('gamegrounds.ground_id',$request->groundid)
      ->get()
      ->toarray();
      return response()->json(["status"=>true,"data"=>$games]);
    }
}
