<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{

    protected $appends = [
        'name',
    ];


    public function breakdowns(): HasMany
    {
        return $this->hasMany('App\Breakdown');
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