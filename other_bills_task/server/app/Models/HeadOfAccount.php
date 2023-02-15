<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadOfAccount extends Model
{
    protected $fillable = [
        "hoa",
        "mjh",
        "mjh_desc",
        "smjh",
        "smjh_desc",
        "mih",
        "mih_desc",
        "gsh",
        "gsh_desc",
        "sh",
        "sh_desc",
        "dh",
        "dh_desc",
        "sdh",
        "sdh_desc",
    ];
}
