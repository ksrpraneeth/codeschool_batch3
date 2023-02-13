<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TimeSlot;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VenueController extends Controller
{
    public function getVenues() {

        $venues = Venue::where('status', '=', 1)->with('sports:name')->get();

        $result = [];

        foreach($venues as $venue) {

            $temp = [
                'id' => $venue->id,
                'name' => $venue->name,
                'phone' => $venue->phone,
                'address' => $venue->address,
                'area' => $venue->area,
                'city' => $venue->city,
                'state' => $venue->state,
                'pincode' => $venue->pincode,
                'thumbnail' => $venue->thumbnail,
                'sports' => []
            ];

            foreach($venue->sports as $sport) {
                $temp['sports'][] = $sport->name;
            }

            array_push($result, $temp);
        }

        return response()->json(['status' => true, 'message' => 'Success', 'data' => $result]);
    }

    
    public function getCities() {

        $cities = DB::table('venues')->distinct()->select('city')->get();

        return response()->json(['status' => true, 'message' => 'Success', 'data' => $cities]);
    }


    public function getSports() {

        $sports = DB::table('sports')->select('id', 'name')->get();

        return response()->json(['status' => true, 'message' => 'Success', 'data' => $sports]);
    }


    public function getVenueDetails(Request $request) {

        $venue = Venue::where('id', $request->get('id'))
                ->with('sports:id,name')
                // ->with('timeSlots:time_slots.id,time_slots.slotname')
                ->first();

        $result = [
            'id' => $venue->id,
            'name' => $venue->name,
            'phone' => $venue->phone,
            'address' => $venue->address,
            'area' => $venue->area,
            'city' => $venue->city,
            'state' => $venue->state,
            'pincode' => $venue->pincode,
            'thumbnail' => $venue->thumbnail,
            'sports' => []
        ];

        foreach($venue->sports as $sport) {
            $result['sports'][] = [
                'id' => $sport->id,
                'name' => $sport->name
            ];
        }

        return response()->json(['status' => true, 'message' => 'success', 'data' => $result]);
    }


    public function getTimeSlots(Request $request) {

        $sportId = $request->get('sport');

        $date = $request->get('date');

        $result = TimeSlot::get();


        return response()->json(['status' => true, 'message' => 'success', 'data' => $result]);

    }

    
}