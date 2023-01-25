<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        "name",
        "dob",
        "email",
        "phone",
        "position",
        "salary",
        "gender"
    ];

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }
}
