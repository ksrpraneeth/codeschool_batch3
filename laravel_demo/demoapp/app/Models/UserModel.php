<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = "users";

    public function address(){
        return $this->hasMany(Address::class,'user_id','id');
    }
}
