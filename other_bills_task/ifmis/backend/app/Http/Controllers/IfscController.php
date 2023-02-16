<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgencyRequest;
use App\Http\Requests\IfscRequest;
use App\Http\Requests\SearchAgencyRequest;
use App\Http\Requests\UpdateAgencyRequest;
use App\Models\Agency;
use App\Models\IfscCode;
use Illuminate\Http\Request;

class IfscController extends Controller
{
     //get ifsc details on entering the ifsc code
    public function ifsccode(IfscRequest $ifscRequest)
    {
       
        $user=$ifscRequest->get('ifsc_code'); //frontend
        $ifscRequest=IfscCode::where('ifsc_code',$user)->first(); //(colname,frontend)
        return response()->json([
            "status"=>true,
            "data"=>$ifscRequest,
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
            $agency=new Agency();
            $agency->agency_name = $agencyRequest->get('agency_name');
            $agency->account_number = $agencyRequest->get('account_number');
            $agency->ifsc_code=$agencyRequest->get('ifsc_code');
            $agency->save();
            return response()->json(['status' => true, "message" => "Agency details entered successfully!"]);
        }
        return response()->json(['status'=>false,'message'=>"Enter valid IFSC Code!"]);
    }
     //get ifsc details on entering the ifsc code
     public function searchagency(SearchAgencyRequest $searchAgencyRequest)
     {
        $searchagency=$searchAgencyRequest->get('account_number');
        if($searchAgencyRequest=Agency::where('account_number',$searchagency)->first()){
            return response()->json([
                "status"=>true,
                "data"=>$searchAgencyRequest,
            ]);
        }
        return response()->json([
            "status"=>false,
            "message"=>"Agency Bank Account not found!"
        ]);
    }
       //update existing agency details
       public function updateagency(UpdateAgencyRequest $updateAgencyRequest,Agency $agency)
       {
        if(!IfscCode::where('ifsc_code',$updateAgencyRequest->ifsc_code)->exists())
        {
            return response()->json(['status' => false, 'message' => "IFSC Code not found!"]);
        }
        $agency->update($updateAgencyRequest->all());
        return response()->json(['status' => true, 'message' => "Agency details changed!"]);
       }
    
     }
    

