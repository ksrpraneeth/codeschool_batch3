<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        "form_type_id",
        "hoa",
        "reference_number",
        "purpose",
        "total_gross",
        "total_pt",
        "total_tds",
        "total_gst",
        "total_gis",
        "total_thn",
        "total_net",
        'tbr_no'
    ];

    public function parties()
    {
        return $this->hasMany(TransactionParty::class);
    }

    public function attachments()
    {
        return $this->hasMany(TransactionAttachment::class);
    }

    public function scrutinyAnswers()
    {
        return $this->hasMany(ScrutinyAnswer::class);
    }

    public function hoaDetails(){
        return $this->belongsTo(HeadOfAccount::class, 'hoa', 'hoa');
    }

    public function formTypeDetails(){
        return $this->belongsTo(FormType::class, 'form_type_id', 'id');
    }
}
