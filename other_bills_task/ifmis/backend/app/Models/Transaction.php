<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable=[
        'form_number',
        'form_type',
        'hoa',
        'reference _number',
        'purpose',
        'gross',
        'ptdedn',
        'tds',
        'gst',
        'gis',
        'thn',
        'netamt'
    ];
    public function multipleAgencies(){
        return $this->hasMany(TransactionManyAgency::class);
    }
    public function formType(){
        return $this->belongsTo(FormType::class,'id','form_type');
    }
    public function hoa(){
        return $this->belongsTo(Hoa::class,'hoa','hoa');
    }
}
