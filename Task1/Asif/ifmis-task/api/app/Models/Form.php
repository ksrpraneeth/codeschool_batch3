<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    public function form_types() {
        $this->hasMany(FormType::class, 'id', 'form_id');
    }
}
