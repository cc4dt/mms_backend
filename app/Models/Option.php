<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $appends = [
        'name',
    ];

    public function getNameAttribute($value)
    {
        return $this->{'name_' . app()->getlocale()};
    }

    public function setNameAttribute($value)
    {
        $this->{'name_' . app()->getlocale()} = $value;
    }

    public function scopeReplaces($query)
    {
        return $query->where('replace', 1);
    }
}
