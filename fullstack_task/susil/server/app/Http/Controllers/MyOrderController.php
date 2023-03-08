<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;
use App\Models\UserModel;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
  public function myOrder(Request $request){
    // $data = order::join('order_details', 'orders.orderid', '=', 'order_details.orderid')
    // ->join('products', 'products.productid', '=', 'order_details.productid')
    // ->select('orders.orderid', 'products.productname', 'products.productimg','order_details.quantity')
    // ->get();


    $userId = Auth::user()->id;

    $data = order::with(['details' => function($query){
        $query->select('orderid','quantity','productid')->with('product:productid,productimg,productname');
    }])->select('orderid','id')->get()->where('id',$userId  );
    
    return response()->json(["status"=>true,'Data'=>$data]);
  }  
}
