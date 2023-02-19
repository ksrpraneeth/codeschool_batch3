<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function multipleBillParties() {
        $this->hasMany(BillMultipleParty::class, 'id', 'transaction_id');
    }


    public function attachments() {
        $this->hasMany(Attachment::class, 'id', 'transaction_id');
    }

    public function transactionScrutinyItems() {
        $this->hasMany(TransactionScrutinyItemsMapping::class, 'id', 'transaction_id');
    }
}
