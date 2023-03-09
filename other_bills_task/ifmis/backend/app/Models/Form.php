<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable=[
        'form_number'
    ];
    public function formTypes(){
        return $this->hasMany(FormType::class, 'form_number_id','id');
        //('foreign key', 'referred to key)
    }
}
