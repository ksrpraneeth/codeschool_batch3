<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormNumber extends Model
{
    protected $fillable = ["form_number"];

    function formTypes()
    {
        return $this->hasMany(FormType::class);
    }
}
