<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;
    protected $table = "sports";

    public function venues() {
        return $this->belongsToMany(Venue::class, 'venue_sport_mappings', 'sport_id', 'venue_id');
    }
    
}
