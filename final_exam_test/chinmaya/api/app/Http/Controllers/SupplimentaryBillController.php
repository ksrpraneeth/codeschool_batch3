<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchEmployeeRequest;
use App\Models\BillType;
use App\Models\deduction;
use App\Models\Earning;
use App\Models\Employee;
use App\Models\Transaction;
use App\Models\TransactionDateDeductionBridge;
use App\Models\TransactionDateEarningBridge;
use App\Models\transaction_multipledate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplimentaryBillController extends Controller
{
    public function AllBillTypes()
    {
        try {
            $billtypes = BillType::select('id', 'name')->get()->toArray();
            $status = true;
            $message = 'Bill type fetch successfully';
            $data = $billtypes;
        } catch (\Exception $e) {
            $status = false;
            $message = 'Failed to fetch bill types ';
            $data = null;
        }

        return response()->json(["status" => $status, "message" => $message, "data" => $data]);

    }

    public function EarningAndDeductions()
    {
        try {
            $earning = Earning::select('id', 'name')->orderBy('id')
                ->get()->toarray();
            $deduction = deduction::select('id', 'name')
                ->orderBy('id')
                ->get()->toarray();

            $status = true;
            $message = "Data fetched Succesfully";
            $data = [$earning, $deduction];
        } catch (\Exception $e) {
            $status = false;
            $message = "Data can not be fetched";
            $data = [];
        }
        return response()->json(['status' => $status, "message" => $message, "data" => $data]);
    }

    public function SearchEmployee(SearchEmployeeRequest $request)
    {
        try {
            $employee = Employee::select('employee_unique_id', 'name')
                ->where('employee_unique_id', $request->employeeId)->get()->toarray();

            if (count($employee) == 0) {
                $status = false;
                $message = "Employee Does not exists";
                $data = [];
            } else {
                $status = true;
                $message = "Employee found";
                $data = $employee;
            }
        } catch (\Exception $e) {
            $status = false;
            $message = 'Data can not be fetched';
        }

        return response()->json(["status" => $status, "message" => $message, "data" => $data]);
    }

    //saving the transaction

    public function TransactionSave(Request $request)
    {

        DB::beginTransaction();
        try {
            $transaction = new Transaction();
            $transaction->employee_id = $request->employeeId;
            $transaction->bill_type_id = $request->billtypeId;
            $transaction->total_earning = $request->totalearning;
            $transaction->total_deduction = $request->totaldeduction;
            $transaction->save();

            foreach ($request->amount as $data) {
                $date = new transaction_multipledate();
                $date->transaction_id = $transaction->id;
                $date->start_date = $data['startDate'];
                $date->end_date = $data['endDate'];
                $date->total_earning = $data['totalEarning'];
                $date->total_deduction = $data['totalDeduction'];
                $date->save();
                $earning = [];
                $deduction = [];
                foreach ($data['earning'] as $data2) {
                    $earning[] = [
                        "transaction_multipledates_id" =>$date->id,
                        "earning_id" => $data2['amountId'],
                        "amount" => $data2['amount'],
                    ];
                }

                foreach ($data['deduction'] as $data3) {
                    $earning[] = [
                        "transaction_multipledates_id" =>$date->id,
                        "deduction_id" => $data3['amountId'],
                        "amount" => $data3['amount'],
                    ];
                }

                TransactionDateEarningBridge::insert($earning);
                TransactionDateDeductionBridge::insert($deduction);

            }

            DB::commit();
            $status = true;
            $message = "Bill added succesfully.";

        } catch (\Exception $e) {
            DB::rollBack();
            $status = false;
            $message = $e->getMessage();
        }
        return response()->json(["status" => $status, "message" => $message]);

    }
}
