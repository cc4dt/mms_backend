<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FcmToken extends Model
{
    
    protected $fillable = [
        'token',
        'device_name',
        'device_type',
        'user_id',
    ];
}
