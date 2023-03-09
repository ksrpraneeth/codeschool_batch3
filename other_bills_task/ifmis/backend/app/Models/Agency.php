<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;
    protected $fillable = [
        "agency_name",
        "ifsc_code",
        "account_number",

    ];
    //many agencies can have one ifsc code so it's belongsTo or many to one
    public function agencyIfsc()
    {
        return $this->belongsTo(IfscCode::class,'ifsc_code','ifsc_code');
        //('col name which is foreign key in agency table','col name in ifsc table which is primary key)
    }
}
