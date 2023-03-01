<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ground extends Model
{
    use HasFactory;


    public function slot() {
        return $this->hasOne(slot::class, 'id', 'ground_id');
    }
    
    public function sports(){
        return $this->hasMany(sport::class, 'id', 'sport_id');
     }
}
