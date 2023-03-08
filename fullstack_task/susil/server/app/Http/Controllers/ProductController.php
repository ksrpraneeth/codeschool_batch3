<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use DB;

class ProductController extends Controller
{

   public function product_list(){
    return response()->json(["status"=>true,"output"=>Product::all()]);
   } 
}