<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        "employee_id",
        "from",
        "to",
        "type",
        "reason",
    ];
}
