<?php

namespace App\Http\Controllers;

use App\Http\Requests\EarningRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\Deduction;
use App\Models\Earning;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //get employee details on search button
    public function employeedetails(EmployeeRequest $employeeRequest){
        $user=$employeeRequest->get('emp_code'); 
        if($employeeRequest=Employee::where('emp_code',$user)->first()){
            return response()->json([
                "status"=>true,
                "data"=>$employeeRequest,
            ]);
        }
        return response()->json([
            "status"=>false,
            "message"=>"Employee code not found!"
        ]);
    }
    //get earning types on earning check
    public function earningtypes(){
        $earning = Earning::get()->all();
        $dedn=Deduction::get()->all();
        return response()->json([
            "status" => true,
            "data" => [$earning,$dedn]
        ]);
     }
    
    }

