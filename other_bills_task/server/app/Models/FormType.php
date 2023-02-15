<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormType extends Model
{
    protected $fillable = ["form_type", "form_number_id"];

    function hoas()
    {
        return $this->belongsToMany(HeadOfAccount::class, "form_type_hoas")->withPivot('id');
    }

    function scrutinyItems()
    {
        return $this->hasMany(ScrutinyItem::class);
    }
}
