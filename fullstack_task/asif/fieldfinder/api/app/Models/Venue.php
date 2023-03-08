<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    use HasFactory;
    protected $table = "venues";

    public function sports() {
        // return $this->hasMany(VenueSportMapping::class, 'venue_id', 'id');
        return $this->belongsToMany(Sport::class, 'venue_sport_mappings', 'venue_id', 'sport_id');
    }

    public function timeSlots() {
        return $this->hasManyThrough(TimeSlot::class, VenueSportMapping::class, 'venue_id', 'venue_sport_mappings_id', 'id', 'id' );
    }
}
