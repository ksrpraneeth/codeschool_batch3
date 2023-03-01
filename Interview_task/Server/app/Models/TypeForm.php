<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeForm extends Model
{
    protected $fillable=[
        'name',
        'type_id'
    ];
    public function types(){
        return $this->belongsTo(Type::class,'type_id','id');
    }
}
