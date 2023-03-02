<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionAttachment extends Model
{
    protected $fillable = [
        "transaction_id",
        "file_path"
    ];
}
