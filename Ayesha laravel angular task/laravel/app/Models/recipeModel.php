<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class recipeModel extends Model
{
    protected $fillable = [
        "recipe_name",
        "cuisine",
        "chef",
        "description"

    ];
    public function ingredients()
    {
            return $this->belongsToMany(ingredient::class, 'add_ingredients', 'recipe_id', 'ingredient_id')->withTimestamps();
            //modelname
    }
}
