<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrutinyAnswer extends Model
{
    protected $fillable = [
        "transaction_id",
        "desc",
        "answer"
    ];
}
