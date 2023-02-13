<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;

class order extends Model
{
    use HasFactory;
    protected $primaryKey="orderid";
    protected $table = "orders";
    public $timestamps = false;
    protected $guarded = [];

    public function details(){
        return $this->hasMany(OrderDetail::class,'orderid','orderid');
    }
}
