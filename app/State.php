<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{

    protected $appends = [
        'name',
    ];


    public function stations(): HasMany
    {
        return $this->hasMany('App\Station');
    }

    public function getNameAttribute($value)
    {
        return $this->{'name_' . app()->getlocale()};
    }

    public function setNameAttribute($value)
    {
        $this->{'name_' . app()->getlocale()} = $value;
    }
}