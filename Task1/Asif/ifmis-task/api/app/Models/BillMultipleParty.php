<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillMultipleParty extends Model
{
    use HasFactory;

    public function transaction() {
        $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
