<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function order(Request $request){

        DB::beginTransaction();
        try{
            // return Auth::user()->id;

            $order = Order::create([
                'id' => Auth::user()->id,
                'orderdate' => date("Y-m-d"),
                'addressId' => $request->addressId
            ]);
            // return $request->addressId;

            //return $order;

            $orderid=$order->orderid;
            $items=$request->get('items');
            $orderDetailsArray = [];
            foreach($items as $item){
                $orderDetailsArray[] = [
                    'orderid' => $orderid,
                    'productid' => $item['productid'],
                    'quantity' => $item['quantity']
                ];
            }
            OrderDetail::insert($orderDetailsArray);

            DB::commit();

            return 'success';

        }catch(\Exception $e){
            
            DB::rollback();
            return $e->getMessage();

        }




    }
    
}
