<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ingredient extends Model
{
   protected $fillable=[
    "ingredients"
   ];
   public function addIngredients()
   {
           return $this->hasMany(AddIngredient::class);
           //modelname
   }
}
