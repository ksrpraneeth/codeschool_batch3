<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormType extends Model
{
    use HasFactory;

    public function form_number() {
        $this->belongsTo(Form::class, 'form_id', 'id');
    }

    public function scrutinyItems() {
        $this->hasMany(ScrutinyItem::class, 'id', 'form_type_id');
    }
}
