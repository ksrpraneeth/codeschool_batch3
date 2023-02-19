<?php

namespace App\Http\Controllers;

use App\Models\AgencyDetail;
use App\Models\Bank;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AgencyController extends Controller
{

    // check bank account availability
    public function checkBankAccount(Request $request) {

        $result = AgencyDetail::where('bank_account_number', $request->bank_account_number)->get();

        if(count($result) == 0) {
            return response()->json(['status' => true, 'message' => "Bank Account Number Available to Use"]);    
        }

        return response()->json(['status' => false, 'message' => 'Bank Account Number Already Exist']);
    }



    public function addAgencyDetails(Request $request) {
        
        try {

            $validator = Validator::make($request->all(), [

                'agency_name' => 'required',
                'bank_account_number' => 'required|confirmed|unique:agency_details',
                'gst_number' => 'min:15|max:15|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/i',
                'ifsc_code' => 'required|min:11|max:11|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/i'                
            ]);
    
            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }


            // Inserting the data
            
            $agency = new AgencyDetail;
            $agency->agency_name = $request->agency_name;
            $agency->bank_account_number = $request->bank_account_number;
            $agency->ifsc_code = $request->ifsc_code;
            $agency->gst_number = $request->gst_number;
            $pan_number = substr($request->gst_number, 2, 10);            
            $agency->pan_number = $pan_number;
            $agency->save();

            return response()->json([
                "status" => true,
                "message" => "Agency Details Added Successfully"
            ]);


        }
        catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }



    // get bank details by ifsc code
    public function getBankDetails(Request $request) {

        $result = Bank::where('ifsc_code',$request->ifsc_code)->get();

        if(count($result) == 0) {
            return response()->json(['status' => false, 'message' => 'Invalid IFSC Code']);    
        }

        return response()->json(['status' => true, 'message' => 'Success', 'data' => $result]);
    }




    public function getAgencyDetails(Request $request) {

        $result = AgencyDetail::where('bank_account_number', $request->bank_account_number)->get();

        if(count($result) == 0) {
            return response()->json(['status' => false, 'message' => 'Agency Details Not Found']);    
        }

        return response()->json(['status' => true, 'message' => 'Success', 'data' => $result]);
    }


    public function updateAgencyDetails(Request $request) {

        try {

            $validator = Validator::make($request->all(), [

                'agency_name' => 'required',
                'gst_number' => 'min:15|max:15|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/i',
                'ifsc_code' => 'required|min:11|max:11|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/i'            
            ]);
    
            if($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            
            $agency = AgencyDetail::findOrFail($request->id);

            $agency->agency_name = $request->agency_name;
            $agency->ifsc_code = $request->ifsc_code;
            $agency->gst_number = $request->gst_number;
            $pan_number = substr($request->gst_number, 2, 10);
            $agency->pan_number = $pan_number;
            $agency->save();


            return response()->json([
                "status" => true,
                "message" => "Agency Details Updated Successfully"
            ]);

        }
        catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }

    }
}
