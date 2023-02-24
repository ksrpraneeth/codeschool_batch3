<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function createTransaction(CreateTransactionRequest $request)
    {
        DB::beginTransaction();
        try {
            $form_type_id = $request->input("form_type_id");
            $hoa = $request->input("hoa");
            $reference_number = $request->input("reference_number");
            $purpose = $request->input("purpose");
            $gross = $request->input("gross");
            $pt = $request->input("pt");
            $tds = $request->input("tds");
            $gst = $request->input("gst");
            $gis = $request->input("gis");
            $thn = $request->input("thn");
            $net = $request->input("net");
            $bill_agencies = $request->input("bill_agencies");
            $scrutiny_answers = $request->input("scrutiny_answers");
            $files = $request->file("files");
            $last_transaction = Transaction::latest()->first();
            $tbr_no = 20220000031912;
            if ($last_transaction) {
                $tbr_no = $last_transaction->tbr_no + 1;
            }
            $transaction = Transaction::create([
                "form_type_id" => $form_type_id,
                "hoa" => $hoa,
                "reference_number" => $reference_number,
                "purpose" => $purpose,
                "total_gross" => $gross,
                "total_pt" => $pt,
                "total_tds" => $tds,
                "total_gst" => $gst,
                "total_gis" => $gis,
                "total_thn" => $thn,
                "total_net" => $net,
                "tbr_no" => $tbr_no
            ]);
            $columns = [
                "agency_account_number",
                "agency_name",
                "agency_gst",
                "agency_ifsc_code",
                "agency_bank_name",
                "agency_bank_branch",
                "gross",
                "pt",
                "tds",
                "gst",
                "gis",
                "thn",
                "net",
            ];
            $transaction_agencies = collect($bill_agencies)->map(function ($item) use ($columns) {
                return collect($item)->only($columns)->all();
            });

            if (!$transaction_agencies->every(function ($record) use ($columns) {
                return collect($columns)->every(function ($column) use ($record) {
                    return isset($record[$column]);
                });
            })) {
                DB::rollBack();
                return response()->json([
                    "status" => false,
                    "message" => "Agency Details are missing",
                    "data" => [],
                ], 500);
            }
            // return response()->json($transaction_agencies);

            $transaction->parties()->createMany($transaction_agencies->all());

            $columns = [
                "desc",
                "answer"
            ];
            $scrutiny_answers = collect($scrutiny_answers)->map(function ($item) use ($columns) {
                return collect($item)->only($columns)->all();
            })->all();

            $transaction->scrutinyAnswers()->createMany($scrutiny_answers);

            if ($files) {
                foreach ($files as $file) {
                    $path = $file->store('uploads');
                    $transaction->attachments()->create(["file_path" => $path]);
                }
            }

            DB::commit();

            return response()->json(["status" => true, "data" => $tbr_no]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                "status" => false,
                "message" => "Something went wrong!",
                "data" => $e->getMessage(),
                "line" => $e->getLine()
            ], 500);
        }
    }

    public function getBill(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tbr_no' => 'required|exists:transactions,tbr_no',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => "TBN No Not found!",
                ], 500);
            }


            $bill = Transaction::where(["tbr_no" => $request->tbr_no])->with(["parties", "hoaDetails"])->with(["formTypeDetails" => function ($q) {
                $q->with("formNumberDetails");
            }])->first();
            return response()->json([
                "status" => true,
                "message" => "Success",
                "data" => $bill
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                "status" => false,
                "message" => "Something went wrong!",
                "data" => $e->getMessage()
            ], 500);
        }
    }
}
