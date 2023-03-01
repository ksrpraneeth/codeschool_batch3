<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Booking extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function user() {
        return $this->belongsTo(user::class);
    }

   public function booking_slot(){
        return $this->hasOne(BookingSlot::class, 'id', 'slot_id');
   }
}
