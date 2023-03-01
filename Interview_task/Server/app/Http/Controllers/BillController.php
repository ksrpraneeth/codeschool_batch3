<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Bill_entries;
use App\Models\Employee;
use App\Models\TypeForm;
use DB;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function getEmployeeDetails(Request $request)
    {
        $id = $request->get('id');
        $details = Employee::where('id', $id)
            ->first();
        if (!$details) {
            return response()->json([
                "status" => false,
                "message" => 'Employee Not Found',
            ]);
        }
        return response()->json([
            "status" => true,
            "data" => $details,
        ]);
    }
    public function getTypeForms(Request $request)
    {
        $id = $request->get('id');
        $details = TypeForm::where('type_id', $id)->select('name', 'id', 'type_id')
            ->get();
        if (!$details) {
            return response()->json([
                "status" => false,
                "message" => 'Types Not Found',
            ]);
        }
        return response()->json([
            "status" => true,
            "data" => $details,
        ]);
    }
    public function submitBill(Request $request)
    {
        DB::beginTransaction();
        try {
            $total_earnings = json_decode($request->get('total_earnings'));
            if (($total_earnings)!=null) {
                $total_earning = collect($total_earnings)->sum('amount');
            } else {
                $total_earning = 0;
            }
            $total_deductions = json_decode($request->get('total_deductions'));
            if (($total_deductions)!=null) {
                $total_deduction = collect($total_deductions)->sum('amount');
            } else {
                $total_deduction = 0;
            }
            $bill = new Bill();
            $bill->employee_id = $request->get('employee_id');
            $bill->total_earnings = $total_earning;
            $bill->total_deductions = $total_deduction;
            $bill->total_net_amount = ($request->get('total_earnings') - $request->get("total_deductions"));
            $bill->save();

            $bill_entries = json_decode($request->get('types_bill'));
            $bill_types = [];
            foreach ($bill_entries as $bill_entry) {
                $bill_types[] = [
                    'bill_id' => $bill->id,
                    'from_date' => $bill_entry->from_date,
                    'to_date' => $bill_entry->to_date,
                    'type_form_id' => $bill_entry->type_id,
                    'Total_amount' => $bill_entry->amount
                ];
            }
            Bill_entries::insert($bill_types);

            DB::commit();
            return response()->json(['status' => true, "message" => "Bill Added Successfully"]);
        } catch (\Throwable $e) {
            DB::rollBack();
            $total_earnings = json_decode($request->get('total_earnings'));
            if (($total_earnings)!=null) {
                $total_earning = collect($total_earnings)->sum('amount');
            } else {
                $total_earning = 0;
            }
            return response()->json([
                'status' => false,
                "message" => 'Bill Submission Failed',
                'data' => [
                    $e->getMessage(),
                    $total_earnings
                ]
            ]);
        }
    }
}