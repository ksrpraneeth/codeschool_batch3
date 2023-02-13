<?php

namespace App\Http\Controllers;

use App\Http\Requests\pincodesearchRequest;
use App\Models\ground;
use Illuminate\Http\Request;

class stadiumlistController extends Controller
{
    //
    public function StadiumList(pincodesearchRequest $request){

        
        if(!(ground::where('pincode',$request->pincode)->exists())){
            return response()->json(["status"=>false,"message"=>"No ground available at this pincode"]);
        }
        $grounds=ground::where('pincode',$request->pincode)->where('state_id',$request->stateid)->get()->toarray();
        if(count($grounds)==0){
            return response()->json(["status"=>false,"message"=>"No ground available "]);
        }
        return response()->json(["status"=>true,"data"=>$grounds]);

    }
}
