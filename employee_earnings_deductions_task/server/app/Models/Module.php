<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }
}
