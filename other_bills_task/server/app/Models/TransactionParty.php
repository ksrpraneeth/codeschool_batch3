<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionParty extends Model
{
    protected $fillable = [
        "transaction_id",
        "agency_account_number",
        "agency_name",
        "agency_gst",
        "agency_ifsc_code",
        "agency_bank_name",
        "agency_bank_branch",
        "gross",
        "pt",
        "tds",
        "gst",
        "gis",
        "thn",
        "net",
    ];
}
