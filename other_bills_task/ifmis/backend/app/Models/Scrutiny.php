<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scrutiny extends Model
{
    use HasFactory;
    function scrutiny(){
        return $this->belongsToMany(Hoa::class, 'hoa_forms', 'form_type_id', 'hoa_id');
    }
}

