<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddIngredient extends Model
{
    protected $fillable = [
        "recipe_id",
        "ingredient_id",
    ];

    
}
