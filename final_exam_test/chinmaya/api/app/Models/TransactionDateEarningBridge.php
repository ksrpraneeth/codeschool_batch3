<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDateEarningBridge extends Model
{
    use HasFactory;
    protected $fillable=["transaction_multipledates_id","earning_id","amount"];
}
