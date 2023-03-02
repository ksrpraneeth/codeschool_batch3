<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModule extends Model
{
    function module(){
        return $this->belongsTo(Module::class);
    }
    function user(){
        return $this->belongsTo(User::class);
    }
}
