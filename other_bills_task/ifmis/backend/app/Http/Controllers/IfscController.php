<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgencyRequest;
use App\Http\Requests\FormtypeRequest;
use App\Http\Requests\hoaformRequest;
use App\Http\Requests\IfscRequest;
use App\Http\Requests\SearchAgencyRequest;
use App\Http\Requests\TransactionRequest;
use App\Http\Requests\UpdateAgencyRequest;
use App\Models\Agency;
use App\Models\Form;
use App\Models\FormType;
use App\Models\HoaForm;
use App\Models\IfscCode;
use App\Models\Scrutiny;
use App\Models\ScrutinyResponse;
use App\Models\Transaction;
use App\Models\TransactionManyAgency;
use Illuminate\Http\Request;

class IfscController extends Controller
{
    //get ifsc details on entering the ifsc code
    public function ifsccode(IfscRequest $ifscRequest)
    {

        $user = $ifscRequest->get('ifsc_code'); //frontend
        $ifscRequest = IfscCode::where('ifsc_code', $user)->first(); //(colname,frontend)
        return response()->json([
            "status" => true,
            "data" => $ifscRequest,
        ]);
    }
    //add agency details to db
    public function agencydetails(AgencyRequest $agencyRequest)
    {

        //check if account number already exists or not
        if (Agency::where('account_number', $agencyRequest->get('account_number'))->exists()) {
            return response()->json(['status' => false, "message" => "Account number already exists!"]);
        }
        if (IfscCode::where('ifsc_code', $agencyRequest->get('ifsc_code'))->exists()) {
            $agency = new Agency();
            $agency->agency_name = $agencyRequest->get('agency_name');
            $agency->account_number = $agencyRequest->get('account_number');
            $agency->ifsc_code = $agencyRequest->get('ifsc_code');
            $agency->save();
            return response()->json(['status' => true, "message" => "Agency details entered successfully!"]);
        }
        return response()->json(['status' => false, 'message' => "Enter valid IFSC Code!"]);
    }
    //get ifsc&agency details on entering the account number
    public function searchagency(SearchAgencyRequest $searchAgencyRequest)
    {
        $searchagency = $searchAgencyRequest->get('account_number');
        // DB::enableQueryLog();
        if ($searchAgencyRequest = Agency::where('account_number', $searchagency)->with('agencyIfsc')->first()) {
            //with('function name of many to one relationship)
            return response()->json([
                "status" => true,
                "data" => $searchAgencyRequest,
            ]);
        }
        //dump(DB::getQueryLog());
        return response()->json([
            "status" => false,
            "message" => "Agency Bank Account not found!"
        ]);
    }
    //update existing agency details
    public function updateagency(UpdateAgencyRequest $updateAgencyRequest, Agency $agency)
    {
        if (!IfscCode::where('ifsc_code', $updateAgencyRequest->ifsc_code)->exists()) {
            return response()->json(['status' => false, 'message' => "IFSC Code not found!"]);
        }
        $agency->update($updateAgencyRequest->all());
        return response()->json(['status' => true, 'message' => "Agency details changed!"]);
    }
    //get forms form-number from db into select box
    public function getforms()
    {
        $forms = Form::get()->all();
        return response()->json([
            "status" => true,
            "data" => $forms
        ]);
    }
    //get form-type from db into select box according to form-number id
    public function getformtype(FormtypeRequest $formtypeRequest)
    {
        $id = $formtypeRequest->get('form_number_id');
        $formtype = FormType::where('form_number_id', $id)->get();
        return response()->json([
            "status" => true,
            "data" => $formtype
        ]);
        // $formtype=FormType::get()->all();
        // return response()->json([
        //     "status"=>true,
        //     "data"=>$formtype
        //]);
    }
    //get hoa-number from db into select box according to form_type id
    public function gethoaformtype(hoaformRequest $hoaformRequest)
    {
        $id = $hoaformRequest->get('form_type_id');
        $hoaForm = FormType::where('id', $id)->first()->hoas;
        //to get scrutiny items
        $scrutiny = FormType::where('id', $id)->first()->scrutiny;
        return response()->json([
            "status" => true,
            "data" => [$hoaForm, $scrutiny]
        ]);
    }

    //get all transaction details
    public function transactiondetails(TransactionRequest $transactionRequest)
    {
        $transaction = new Transaction();
        $transaction->form_number = $transactionRequest->get('form_number');
        $transaction->form_type = $transactionRequest->get('form_type');
        $transaction->hoa = $transactionRequest->get('hoa');
        $transaction["reference _number"] = $transactionRequest->get('reference_number');
        $transaction->purpose = $transactionRequest->get('purpose');
        $transaction->ptdedn = $transactionRequest->get('ptdedn');
        $transaction->gross = $transactionRequest->get('gross');
        $transaction->tds = $transactionRequest->get('tds');
        $transaction->gst = $transactionRequest->get('gst');
        $transaction->gis = $transactionRequest->get('gis');
        $transaction->thn = $transactionRequest->get('thn');
        $transaction->netamt = $transactionRequest->get('netamt');
        $transaction->save();
        //from front end get the agency details and store it in a $variable
        $bill_multiple_parties = json_decode($transactionRequest->get('agency_details'));
        $party=[];
        foreach ($bill_multiple_parties as $bill_multiple_party) {
           $party[]=[
            'transaction_id'=>$transaction->id,
            'agency_name'=>$bill_multiple_party->agency_name,
            'agency_bank_account'=>$bill_multiple_party->account_number,
            'agency_bank_name'=>$bill_multiple_party->bank_name,
            'agency_bank_branch'=>$bill_multiple_party->bank_branch,
            'ifsc_code'=>$bill_multiple_party->ifsc_code,
            'gross'=>$bill_multiple_party->gross,
            'ptdedn' => $bill_multiple_party->ptdedn,
            'tds' => $bill_multiple_party->tds,
            'gst' =>$bill_multiple_party->gst,
            'gis'=> $bill_multiple_party->gis,
            'thn'=> $bill_multiple_party->thn,
            'netamt' =>$bill_multiple_party->netamt,
           ];
        }
        TransactionManyAgency::insert($party);
        return response()->json(['status' => true, "message" => "Bill Added Successfully", "data" => $transaction->id]);
    }
    public function billDetails(Request $request)
    {
        $id = $request->get('id');
        $transaction = Transaction::with([
                'formType' => function ($q) {
                    $q->with('formNo');
                }
            ])
            ->with('hoa')
            ->where('id', $id)
            ->get()->toArray();
        if (!$transaction) {
            return response()->json(['status' => false, 'message' => 'Invalid Bill']);
        }
        $transaction_many_agencies = Transaction::where('id', $id)->first()->multipleAgencies;
        return response()->json([
            'status' => true,
            'message' => 'Transaction details!',
            'data' => [
                'transaction' => $transaction,
                'agenciesDetailBill' => $transaction_many_agencies
            ]
        ]);
    }
}

// $party = new TransactionManyAgency();
// $party->transaction_id = $transaction->id;
// $party->agency_name = $bill_multiple_party->agency_name;
// $party->agency_bank_account = $bill_multiple_party->account_number;
// $party->agency_bank_name = $bill_multiple_party->bank_name;
// $party->agency_bank_branch = $bill_multiple_party->bank_branch;
// $party->ifsc_code = $bill_multiple_party->ifsc_code;
// $party->gross = $bill_multiple_party->gross;
// $party->ptdedn = $bill_multiple_party->ptdedn;
// $party->tds = $bill_multiple_party->tds;
// $party->gst = $bill_multiple_party->gst;
// $party->gis = $bill_multiple_party->gis;
// $party->thn = $bill_multiple_party->thn;
// $party->netamt = $bill_multiple_party->netamt;
// $party->save();