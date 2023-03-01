<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSlot extends Model
{
    
    public function gameground(){
        return $this->hasOne(gameground::class, 'id', 'gameground_id');
    }
}
