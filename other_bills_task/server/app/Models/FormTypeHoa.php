<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTypeHoa extends Model
{
    protected $fillable = [
        "form_type_id",
        "head_of_account_id"
    ];
}
