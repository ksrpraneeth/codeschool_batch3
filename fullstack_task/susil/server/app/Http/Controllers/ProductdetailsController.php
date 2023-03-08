<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use DB;

class ProductdetailsController extends Controller
{
    public function product_details(Request $request){
        $productId = $request->id;
        $data = Product::where('productid',$productId)->first();
       return response()->json(["status"=>true,"output"=>$data]);
    }
}
