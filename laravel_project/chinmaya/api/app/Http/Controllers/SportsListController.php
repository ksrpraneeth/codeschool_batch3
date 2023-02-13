<?php

namespace App\Http\Controllers;

use App\Models\sport;
use Illuminate\Http\Request;

class sportsListController extends Controller
{
    //sports list
  public function SportsList(){
    $sports=sport::get()->toarray();
    return response()->json(["status"=>true,"data"=>$sports]);
  }
    
}
