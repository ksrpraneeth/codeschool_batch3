<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class OrderDetail extends Model
{
    use HasFactory;
    protected $primarykey="orderdetailsid";
    public $timestamps = false;

    public function product(){
        return $this->hasOne(Product::class,'productid','productid');
    }
}
