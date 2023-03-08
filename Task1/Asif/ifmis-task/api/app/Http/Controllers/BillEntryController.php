<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormType;
use App\Models\ScrutinyItem;
use Illuminate\Http\Request;

class BillEntryController extends Controller
{
    public function getFormNumbers() {

        $result = Form::all();

        if(count($result) == 0) {
            return response()->json(['status' => false, 'message' => 'No Records Found']);    
        }

        return response()->json(['status' => true, 'message' => 'Success', 'data' => $result]);
    }

    public function getFormTypes() {

        $result = FormType::all();

        if(count($result) == 0) {
            return response()->json(['status' => false, 'message' => 'No Records Found']);    
        }

        return response()->json(['status' => true, 'message' => 'Success', 'data' => $result]);
    }


    public function getScrutinyItems(Request $request) {
        
        $result = ScrutinyItem::where('form_type_id', $request->form_type_id)->get();

        if(count($result) == 0) {
            return response()->json(['status' => false, 'message' => 'No Records Found']);    
        }

        return response()->json(['status' => true, 'message' => 'Success', 'data' => $result]);
    }
}
