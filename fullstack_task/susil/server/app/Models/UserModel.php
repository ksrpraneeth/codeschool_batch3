<?php

namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Models\order;


// class UserModel extends Model
// {
//     // use HasFactory;
//     protected $table = "users";
// }

class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory,HasApiTokens, Notifiable;
    protected $table = "users";

    public function user(){
        return $this->hasOne(order::class,'id','id'); 
    }

    
    public function getJWTIdentifier()
    {
       return $this->getKey();
    }
    public function getJWTCustomClaims()
    { 
        return [];
    }
}