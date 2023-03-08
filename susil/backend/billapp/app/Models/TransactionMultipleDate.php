<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionMultipleDate extends Model
{
    use HasFactory;

    protected $fillable = ['transaction_id','start_date','end_date','total_earning','total_deduction'];
}
