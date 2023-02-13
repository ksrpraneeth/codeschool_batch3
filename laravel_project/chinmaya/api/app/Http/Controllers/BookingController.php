<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\gameground;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    //see available time slot for booking
    public function AvailableTimeSlot(Request $request)
    {
        // $gamegroundid = gameground::select('id', 'price')->where('sport_id', $request->sport_id)->where('ground_id', $request->ground_id)->get()->toarray();
        // $date = $request->booking_date;

        // $booking_slot = BookingSlot::where('gameground_id', $gamegroundid[0]['id'])->where('day_id', $request->day_id)->whereNotIn('id', function ($query) use ($date) {

        //     $query->select('slot_id')->from('bookings')->where('booking_date', $date);
        // })
        //     ->get()->toarray();
        // if (count($booking_slot) == 0) {
        //     return response()->json(["status" => false, "message" => "No slot available for booking"]);
        // }
        $date = $request->booking_date;
        $day_id = $request->day_id;
        $gamegroundid = gameground::select('id', 'price')
            ->where('sport_id', $request->sport_id)
            ->where('ground_id', $request->ground_id)
            ->with(['Slots' => function ($query) use ($date, $day_id) {
                $query->where('day_id', $day_id)->whereNotIn('id', function ($query) use ($date) {

                    $query->select('slot_id')->from('bookings')->where('booking_date', $date);
                });
            }])->get()->toarray();
if(count($gamegroundid[0]['slots'])==0){
    return response()->json(["status" => false, "message" => "No slot available for booking"]); 
}
        return response()->json(["status" => true, "data" => $gamegroundid]);
    }
    

    //book for a particluar user
    public function BookGround(Request $request)
    {

        $booking = new Booking();
        $booking->slot_id = $request->slot_id;
        $booking->user_id = Auth::user()->id;
        $booking->booking_date = $request->booking_date;
        $booking->booking_status = 1;
        $booking->save();

        return response()->json(["status" => true, "message" => "Booking Suceessful"]);
    }

    //booking history

    public function BookingHistory(Request $request)
    {

        // $booking_slot = BookingSlot::join('gamegrounds','booking_slots.gameground_id','=','gamegrounds.id')
        // ->join('sports','gamegrounds.sport_id','=','sports.id')
        // ->join('grounds','gamegrounds.ground_id','=','grounds.id')
        // ->join('bookings','booking_slots.id','=','bookings.slot_id')
        // ->select('booking_slots.start_time','booking_slots.end_time','gamegrounds.price','sports.name as sport_name','grounds.*','bookings.booking_date')

        // ->where('bookings.user_id', Auth::user()->id)->get()->toarray();

        // $booking_slot = Booking::select('id','user_id','ground_id')
        // ->with('user:id,name,email,phone')
        // ->with(['ground' => function($query) {
        //     $query->select('id','name');
        //     $query->with('slot:id,name,email,phone');
        //  }])
        // ->where('user_id', Auth::user()->id)
        // ->get()->toarray();

        $booking_slot = Booking::select('id', 'slot_id', 'user_id', DB::raw("to_char(booking_date, 'DD-MM-YYYY') as booking_date"), 'booking_status')
            ->where('user_id', Auth::user()->id)
            ->with(['booking_slot' => function ($query) {
                $query->select('id', 'gameground_id', 'start_time', 'end_time');
                $query->with(['gameground' => function ($query) {
                    $query->select('id', 'ground_id', 'sport_id', 'price');
                    $query->with('ground:id,name,address,landmark,pincode,contactnumber');
                }]);

            }])
            ->get()->toarray();

        if (count($booking_slot) == 0) {
            return response()->json(["status" => false, "message" => "No Bookings"]);
        }
        return response()->json(["status" => true, "message" => 'Success', "data" => $booking_slot]);

    }
}
