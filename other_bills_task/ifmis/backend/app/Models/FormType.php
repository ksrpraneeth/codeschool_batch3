<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormType extends Model
{
    use HasFactory;
    protected $fillable=[
        'form_number_id',
        'form_type'
    ];
    function hoas(){
        return $this->belongsToMany(Hoa::class, 'hoa_forms', 'form_type_id', 'hoa_id');
    }
    public function scrutiny()
    {
            return $this->hasMany(Scrutiny::class);
            //modelname
    }
    public function formNo()
    {
        return $this->hasOne(Form::class,'id','form_number_id');
    }
}
