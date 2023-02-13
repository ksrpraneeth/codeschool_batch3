<?php

namespace App\Http\Controllers;

use App\Models\sport;
use App\Models\state;
use Illuminate\Http\Request;

class statelistController extends Controller
{
    //
    public function StateList(){
        $statelist=state::all()->toArray();
        $gamename=sport::whereNull('parent_id')->get()->toArray();
        

        return response()->json(["status"=>true,"data"=>[$statelist,$gamename]]);
    }
}
