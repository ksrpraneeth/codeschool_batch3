<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    function ifscCodeDetails()
    {
        return $this->belongsTo(IfscCode::class, 'ifsc_code', 'ifsc_code');
    }
}
