<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Earning;
use App\Models\Deduction;
use App\Models\Transaction;
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
                    'start_date' => $request->$data['startdate'],
                    'end_date' => $request->$data['enddate'],
                    'total_earnings' => $request->multipledateGross,
                    'total_deductions' => $request->multipledateDeduction,


                ]);
            }







            DB::commit();
            return response()->json(["status" => true, 'message' => 'Bill Submit Successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }
}
