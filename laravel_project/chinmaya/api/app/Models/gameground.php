<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gameground extends Model
{
    use HasFactory;
    public function ground(){
        return $this->hasOne(ground::class,'id','ground_id');
    }
    
    public function sport(){
       return $this->hasOne(sport::class,'id','sport_id');
    }

    public function Slots(){
        return $this->hasMany(BookingSlot::class,'gameground_id','id');
    }
}
