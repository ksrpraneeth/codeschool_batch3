<?php

namespace App\Http\Controllers;

use App\Http\Requests\EarningRequest;
use App\Http\Requests\EmployeeRequest;
use App\Models\BillTransaction;
use App\Models\Deduction;
use App\Models\Earning;
use App\Models\EarningDedn;
use App\Models\Employee;
use App\Models\SalaryType;
use App\Models\SupplementaryBill;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    //get employee details on search button
    public function employeedetails(EmployeeRequest $employeeRequest)
    {
        $user = $employeeRequest->get('emp_code');
        if ($employeeRequest = Employee::where('emp_code', $user)->first()) {
            return response()->json([
                "status" => true,
                "data" => $employeeRequest,
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "Employee code not found!"
        ]);
    }
    //get earning types on earning check
    public function earningtypes(Request $request)
    {
        $gettype = SalaryType::all();
        return response()->json([
            "status" => true,
            "data" => $gettype
        ]);
    }
    public function paySlip(Request $request)
    {
        $employeeDetails = new SupplementaryBill();
        $employeeDetails->emp_code = $request->get('emp_code');
        $employeeDetails->save();
        //bill_transactions
        $dateDetails = json_decode(($request->get('emp_array')));
        $billTransactions = [];
        foreach ($dateDetails as $dateDetail) {
            $newBillTransaction = new BillTransaction();
            $newBillTransaction->supply_bill_id = $employeeDetails->id;
            $newBillTransaction->from_date = $dateDetail->fromDate;
            $newBillTransaction->to_date = $dateDetail->toDate;
            $newBillTransaction->save();
            //Create a new array of earnings and deductions
            $earningsAndDeductions = [];
            foreach ($dateDetail->earnings as $earning) {
                $earningsAndDeductions[] = [
                    "bill_transactions_id" => $newBillTransaction->id,
                    "salary_type_id" => $earning->id,
                    "amount" => $earning->amount,
                ];
            }
            foreach ($dateDetail->dedns as $deduction) {
                $earningsAndDeductions[] = [
                    "bill_transactions_id" => $newBillTransaction->id,
                    "salary_type_id" => $deduction->id,
                    "amount" => $deduction->amount,
                ];
            }
            EarningDedn::insert($earningsAndDeductions);
        }
        return response()->json([
            'status'=>'true',
            'message'=>'Payslip inserted!'
        ]);
    }
}

        // $earning = Earning::get()->all();
        // $dedn=Deduction::get()->all();
        // return response()->json([
        //     "status" => true,
        //     "data" => [$earning,$dedn]
        // ]);
    //  }
    
    // }
