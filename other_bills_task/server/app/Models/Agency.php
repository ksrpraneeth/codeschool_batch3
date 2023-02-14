<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = [
        "agency_name",
        "account_number",
        "gst_no",
        "ifsc_code"
    ];
    function ifscCodeDetails()
    {
        return $this->belongsTo(IfscCode::class, 'ifsc_code', 'ifsc_code');
    }
}
