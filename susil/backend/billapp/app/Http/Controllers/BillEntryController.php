<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Earning;
use App\Models\Deduction;
use App\Models\Transaction;
use App\Models\TraasactionDateEarningMapping;
use App\Models\TransactionDateDeductionMapping;


use App\Models\TransactionMultipleDate;

use Exception;
use Illuminate\Support\Facades\DB;

class BillEntryController extends Controller
{
    public function employeeDetails(Request $request)
    {
        try {
            $empcode = $request->empCode;
            $data = Employee::where('emp_code', $empcode)->first();
            // return response()->json(["status" => true, 'data' => $data]);
            if (!$data) {
                throw new Exception("Emp code doesn't exists!");
            }

            $status = true;
            $message = "Success!";
        } catch (\Exception $e) {
            $status = false;
            $data = [];
            $message = $e->getMessage();
        }
        return response()->json(["status" => $status, "data" => $data, 'message' => $message]);
    }
    public function earningType(Request $request)
    {
        try {

            $data = Earning::all();
            return response()->json(["status" => true, 'data' => $data]);
        } catch (\Exception $e) {

            return response()->json(['status' => false, "message" => $e->getMessage()]);
        }
    }
    public function deductionType(Request $request)
    {
        try {

            $data = Deduction::all();
            return response()->json(["status" => true, 'data' => $data]);
        } catch (\Exception $e) {

            return response()->json(['status' => false, "message" => $e->getMessage()]);
        }
    }


    
    public function EarningAndDeductions()
    {
        try {
            $earning = Earning::select('id', 'name')->orderBy('id')
                ->get()->toarray();
            $deduction = Deduction::select('id', 'name')
                ->orderBy('id')
                ->get()->toarray();
            $status = true;
        
            $data = [$earning, $deduction];
        } catch (\Exception $e) {
            $status = false;
            $message = "Data can not be fetched";
            $data = [];
        }
        return response()->json(['status' => $status,"data" => $data]);
    }
    public function addEmployeeToBill(Request $request)
    {
        DB::beginTransaction();
        try {


            $transaction = Transaction::create([


                'emp_id' => $request->empId,
                'total_earnings' => $request->totalAmount,
                'total_deductions' => $request->totalDeduction,
                'total_net' => $request->totalNet,

            ]);
            $transactionid = $transaction->id;
            foreach ($request->employeeBillList as $data) {
                $transactionmultipledates = TransactionMultipleDate::create([
                    'transaction_id' => $transactionid,
                    'start_date' => $data['startdate'],
                    'end_date' => $data['enddate'],
                    'total_earning' => $data['multipledateGross'],
                    'total_deduction' => $data['multipledateDeduction'],


                ]);
                $earning=[];
                $deduction=[];
                foreach($data['earning'] as $data2){
                    $earning[]=[
                        'transaction_multipledates_id'=>$transactionmultipledates->id,
                        'earning_id'=>$data2['amountId'],
                        'amount'=>$data2['amount'],
                    ];
                }
                foreach($data['deduction'] as $data3){
                    $deduction[]=[
                        'transaction_multipledates_id'=>$transactionmultipledates->id,
                        'deduction_id'=>$data3['amountId'],
                        'amount'=>$data3['amount'],
                    ];
                }
                TraasactionDateEarningMapping::insert($earning);
                TransactionDateDeductionMapping::insert($deduction);

                
                
            }

            DB::commit();
            return response()->json(["status" => true, 'message' => 'Bill Submit Successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
