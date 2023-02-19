<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgencyDetail extends Model
{
    use HasFactory;

    public function setAgencyNameAttribute($value)
    {
        $this->attributes['agency_name'] = strtoupper($value);
    }

    public function setGstNumberAttribute($value)
    {
        $this->attributes['gst_number'] = strtoupper($value);
    }

    public function setPanNumberAttribute($value)
    {
        $this->attributes['pan_number'] = strtoupper($value);
    }
}
