<?php

namespace App\Http\Controllers;

use App\Http\Requests\IfscRequest;
use App\Models\IfscCode;
use Illuminate\Http\Request;

class IfscController extends Controller
{
    public function ifsccode(IfscRequest $ifscRequest)
    {
        $user=$ifscRequest->get('ifsc_code'); //frontend
        $ifscRequest=IfscCode::where('ifsc_code',$user)->first(); //(colname,frontend)
        return response()->json([
            "status"=>true,
            "data"=>$ifscRequest,
        ]);
    }
}
