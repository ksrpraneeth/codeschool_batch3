<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillTransaction extends Model
{
    use HasFactory;
    function billEarningDedn(){
        return $this->hasMany(EarningDedn::class,'bill_transactions_id');
    }
}
