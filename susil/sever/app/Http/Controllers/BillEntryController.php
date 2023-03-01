<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Earning;
use App\Models\Deduction;
use Exception;

class BillEntryController extends Controller
{
    public function employeeDetails(Request $request){
        try {
        $empcode=$request->empCode;
        $data=Employee::where('emp_code',$empcode)->first();
        // return response()->json(["status" => true, 'data' => $data]);
        if (!$data) {
            throw new Exception("Emp code doesn't exists!");
        }

        $status = true;
        $message = "Success!";


    }catch (\Exception $e) {
        $status = false;
        $data = [];
        $message = $e->getMessage();


      
    }
    return response()->json(["status"=>$status,"data"=>$data,'message'=>$message]);
} 
public function earningType(Request $request){
    try{

        $data=Earning::all();
        return response()->json(["status" => true, 'data' => $data]);

    } catch (\Exception $e) {

        return response()->json(['status' => false, "message" => $e->getMessage()]);
    }

}
public function deductionType(Request $request){
    try{

        $data=Deduction::all();
        return response()->json(["status" => true, 'data' => $data]);

    } catch (\Exception $e) {

        return response()->json(['status' => false, "message" => $e->getMessage()]);
    }

}

}
